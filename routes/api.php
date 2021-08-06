<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Media\AlbumController;
use App\Http\Controllers\Follow\FollowController;
use App\Http\Controllers\FriendShips\FriendShipsController;

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
    return response()->json(['data' => $request->user()]);
});

Route::post('register', [AuthController::class , 'register']);
Route::post('login', [AuthController::class , 'login']);
Route::post('logout', [AuthController::class , 'logout'])->middleware('auth:sanctum');

Route::apiResources([
    '/posts' => PostController::class,
    '/users' => UserController::class,
    '/albums' => AlbumController::class,
]);

Route::post('/user/avatar' , [UserController::class , 'avatar_update'])->middleware('auth:sanctum');
Route::post('/user/wallpaper' , [UserController::class , 'wallpaper_update'])->middleware('auth:sanctum');
Route::post('/posts/{post}/images' , [PostController::class , 'upload_images'])->middleware('auth:sanctum');

Route::post('/auth/friends/{friend}/request' , [FriendShipsController::class , 'befriend']);
Route::post('/auth/friends/{friend}/accept' , [FriendShipsController::class , 'acceptFriendRequest']);
Route::post('/auth/friends/{friend}/deny' , [FriendShipsController::class , 'denyFriendRequest']);


Route::get('/friendposts' , [UserController::class , 'friendship']);
Route::get('/follow' , [FollowController::class , 'follow']);



// Route::mediaLibrary('my-custom-url');