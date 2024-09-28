<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get("/", [PostController::class, "homepage"])->name("homepage");
Route::get("/upload_post", [PostController::class, "upload_post"]);
Route::post("/send_post", [PostController::class, "send_post"]);
Route::post("/search_post", [PostController::class, "search_post"]);
Route::get("/edit_post/{id}", [PostController::class, "edit_post"]);
Route::post("/update_post", [PostController::class, "update_post"]);
Route::get("/view_all_post", [PostController::class, "view_all_post"]);
Route::get("/delete_post/{id}", [PostController::class, "delete_post"]);


Route::get("/create_category", [PostController::class, "create_category"]);
Route::post("/register_category", [PostController::class, "register_category"]);
Route::get("/delete_category/{id}", [PostController::class, "delete_category"]);
Route::get("/edit_category/{id}", [PostController::class, "edit_category"]);
Route::post("/update_category", [PostController::class, "update_category"]);
Route::get("/view_all_category", [PostController::class, "view_all_category"]);


Route::get("/read-article/{id}/{slug}", [PostController::class, "read_article"]);
Route::get("/admin_dashboard", [PostController::class, "admin_dashboard"]);








Route::get("/tag_search/{tag}", [PostController::class, "tag_search"])->name('tag_search');


Route::get("/logout",[UserController::class,"logout"]);
Route::get("/user_login", [UserController::class, "user_login"]);
Route::post("/send_user_login", [UserController::class, "send_user_login"]);
Route::get("/create_user", [UserController::class, "create_user"]);
Route::post("/register_user", [UserController::class, "register_user"]);