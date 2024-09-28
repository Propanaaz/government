<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function admin_dashboard(Request $request){
        if(auth()->check()){
            $post = Post::all();
            return view("admin_dashboard",compact('post'));
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }


    public function homepage(Request $request){
        $category = Category::offset(0)->limit(4)->get();
        $latestpost1 = Post::latest()->offset(0)->limit(1)->get();
        $latestpost2 = Post::latest()->offset(1)->limit(6)->get();
        $allcategory = Category::all();
        $allpost1 = Post::latest()->offset(0)->limit(1)->get();
        $allpost2 = Post::latest()->offset(1)->limit(count(Post::all()))->get();

        return view("homepage",compact('latestpost1','latestpost2','category','allcategory','allpost1','allpost2'));
    }


    public function view_all_post(Request $request){
        if(auth()->check()){
            $post = Post::all();
            return view("view_all_post",compact('post'));
        }else{
            return redirect("/user_login")->with("message","Please Login to Create a Post");
        }
    }


    public function upload_post(Request $request){
        if(auth()->check()){
            $category = Category::all();
            return view("upload_post",compact('category'));
        }else{
            return redirect("/user_login")->with("message","Please Login to Create a Post");
        }
    }



    public function create_category(Request $request){
        if(auth()->check()){
            return view("create_category");
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }



    public function register_category(Request $request){
        if(auth()->check()){
            $data = $request->validate([
            "category_name"=>"required",
            "category_description"=>"required"
            ]);
            Category::create($data);
            return redirect("/create_category")->with("message","Category Created Successfully");
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }



    public function send_post(Request $request){
        if(auth()->check()){
            $title = $request->input("title");
            $data = $request -> validate([
                "title"=>"required",
                "content"=>"required",
                "image"=>"required|mimes:jpeg,png"
            ]);
            $category = Category::where("id",$request->input("category"));
            $arrName = explode(" ",$title);
            $slugged = implode("-",$arrName);
            $data["slug"] = $slugged;
            $filename = uniqid().".".$request->image->extension();
            $data["image"] = $filename;
            $data["category_id"] = $request->input("category");
            Post::create($data);
            $request->image->move(public_path("images"),$filename);
            return redirect("/upload_post")->with("message","uploaded successfully");
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }



public function edit_post(Request $request, int $id){
    if(auth()->check()){
        $post = Post::where("id",$id)->get();
        $category = Category::all();
        $context = [
            "post"=>$post,
            "category"=>$category
        ];
        return view("edit_post",$context);
    }else{
        return redirect("/user_login")->with("message","Please Login");
    }
}



    public function update_post(Request $request){
    if(auth()->check()){
    $data = $request -> validate([
        "title"=>"required",
        "category"=>"required",
        "content"=>"required",
        "image"=>"required|mimes:jpeg,png"
    ]);
    if($request->input("category") == "Choose a Category"){
        return redirect("/edit_post"."/".$request->input("pid"))->with("message","Please Choose a category");
    }
    
    $post = Post::where("id",$request->input("pid"))->first();
    $post->title = $request->input("title");
    $post->content = $request->input("content");
    $post->category_id = $request->input("category");
    $filename = uniqid().".".$request->image->extension();
    $post->image = $filename;
    $arrName = explode(" ",$request->input("title"));
    $slugged = implode("-",$arrName);
    $post->slug = $slugged;
    $post->save();
    $request->image->move(public_path("images"),$filename);
    return redirect("/viw_all_post")->with("message","uploaded successfully");
}else{
    return redirect("/user_login")->with("message","Please Login");
}

}



    public function read_article(Request $request, int $id,string $slug){
        $post = Post::where("id","=",$id)->get();
        $category = Category::all();
        $getcategory = Post::where("id","=",$id)->get();
 
        return view("read_article",compact('post','category','getcategory'));        
    }



    public function search_post(Request $request){
        $search = strip_tags($request->input("search"));
        return redirect()->route('tag_search', ['tag' => $search]);
        // $post = Post::where("title","LIKE","%{$search}%")->get();
        // $category = Category::all();
        // return view("search2",compact('post','category','search'));
    }




    public function tag_search(Request $request, string $tag){
        $post = Post::where("content","like", "%".$tag."%")->get();
        $search = $tag;
        $category = Category::all();
        return view("search_post",compact('post','category','search'));
    }


    public function view_all_category(Request $request){
        if(auth()->check()){
            $category = Category::all();
            return view("view_all_category",compact('category'));
        }else{
            return redirect("/user_login")->with("message","Please Login");

        }
    }



    public function edit_category(Request $request, int $id){
        if(auth()->check()){
            $category = Category::where("id",$id)->get();
            return view("edit_category",compact('category'));
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }



    public function delete_category(Request $request, int $id){
        if(auth()->check()){
            $category = Category::where("id",$id)->first()->delete();
            return redirect("/view_all_category");
        }else{
            return redirect("/user_login")->with("message","Please Login");
        }
    }


    public function delete_post(Request $request, int $id){
        if(auth()->check()){
            $post = Post::where("id",$id)->first()->delete();
        return redirect("/view_all_post");
        }else{
            return redirect("/user_login")->with("message","Please Login");

        }
    }


    public function update_category(Request $request){
        if(auth()->check()){
            $category = Category::where("id",$request->input("cid"))->first();
            $category->category_name = $request->input("category_name");
            $category->category_description = $request->input("category_description");
            $category->save();
            return redirect("/view_all_category")->with("message","Updated successfully");
        
        }else{
            return redirect("/user_login")->with("message","Please Login");

        }
    }


}
