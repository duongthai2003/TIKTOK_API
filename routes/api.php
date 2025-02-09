<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\videocontroller;
use App\Http\Controllers\Commentcontroller;
use App\Http\Controllers\likecontroller;
use App\Http\Controllers\followingcontroller;
use App\Models\Following;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('users',usercontroller::class)->except(['store','login','update','destroy','show']);
Route::post('users/register',[usercontroller::class,'store']);
Route::post('users/login',[usercontroller::class,'login']);
// Route::middleware('auth:api')->get('/users/test', [UserController::class, 'test']); // cái này auth cho từng cái
Route::group(['middleware' => 'auth:api'], function() { // group này nhóm api khi đã đang nhập ms vào được 
    Route::post('users/details', [usercontroller::class,'details']); 
    Route::delete('users/delete/{user}',[usercontroller::class,'destroy']);
    Route::post('users/update/{user}',[usercontroller::class,'update']);
});

Route::get('users/profile/@{nickname}',[usercontroller::class,'getanuser']);
Route::get('users/search',[usercontroller::class,'search']);
Route::get('suggess/users',[usercontroller::class,'suggess']);

// Video
Route::resource('videos',videocontroller::class)->only(['index','show']);
Route::get('search/videos',[videocontroller::class,'searchvideo']);
Route::group(['middleware' => 'auth:api'], function() { 
Route::post('videos/create',[videocontroller::class,'store']);
Route::delete('delete/video',[videocontroller::class,'deleteanvideo']);
});
Route::post('videos/update/{video}',[videocontroller::class,'update']);


// comment
Route::get('comment',[Commentcontroller::class,'index']);
Route::group(['middleware' => 'auth:api'], function() { 
Route::post('comment/create',[Commentcontroller::class,'store']);
Route::delete('comment/delete',[Commentcontroller::class,'destroy']);
});

// like video
Route::group(['middleware' => 'auth:api'], function() { 
Route::get('like_video_list',[likecontroller::class,'index']);
Route::post('like',[likecontroller::class,'store']);
Route::get('like/current-user-liked-video-list',[likecontroller::class,'get_list_video_user_liked']);
});

//following
Route::group(['middleware' => 'auth:api'], function() { 
Route::get("me/following",[followingcontroller::class,'index']);
Route::post("me/following",[followingcontroller::class,"store"]);
Route::get("me/follower",[followingcontroller::class,"getfollowerlist"]);
Route::get("me/friends",[followingcontroller::class,"friendlist"]);
Route::get("me/following/videos",[followingcontroller::class,"followingvideolis"]);
Route::get("me/friends/videos",[followingcontroller::class,"getvideofriend"]);
});