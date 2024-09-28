<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user_login(Request $request){
        return view('user_login');
    }

    public function send_user_login(Request $request){
        $incomingFields = $request->validate([
            'username'=>"required",
            "password"=>"required"
        ]);
        // $incomingFields["name"] = $request->input("username")
        if(auth()->attempt(["email"=>$incomingFields["username"],"password"=>$incomingFields["password"]])){
            $request->session()->regenerate();
            return redirect("/admin_dashboard")->with("message", "Login Successful");

        }

        return redirect("/user_login")->with("message", "Invalid Login Credential");
    }

    public function logout(){
        auth()->logout();
        return redirect("/user_login");
    }



    public function create_user(Request $request){

        return view("create_user");
   
    }



    public function register_user(Request $request){  
        $incomingFields = $request->validate([
            'username'=> ['required'],
            'email'=>['required','email'],
            'password'=>['required','max:15'],
            'password2'=>['required','max:15']
    
        ]);
        $incomingFields["name"] = $request->input("username");
        $password = $incomingFields["password"];

        bcrypt($password);
        $password2 = $incomingFields["password2"]; 
        bcrypt($password2); 
        if($password === $password2){
                $user =  User::create($incomingFields);
                auth()->login($user);
                return redirect("/create_user")->with("message", "Account Creation Successful");
            
           
        }else{
            return redirect("/create_user")->with("message", "Password did not match");

        }
    
         
     




}
}