<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::put('/update-user/{id}', [UserController::class, 'update']);
    Route::post('/posts/save', [PostController::class, 'store']);
    Route::post('/logout',[AuthController::class,'logout']);

    Route::post('/like-post',[LikeController::class,'like']);
    Route::delete('/unlike-post',[LikeController::class,'unlike']);
});

Route::post('/get-post/comments/{id}',[CommentController::class,'show']);

Route::get('/check-post',[PostController::class,'bro']);

Route::post('/like-post',[LikeController::class,'like']);

Route::post('/add-friend',[FriendController::class,'add_friend']);
Route::put('/accept-request',[FriendController::class,'accept_friend']);

Route::post('/add-user', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/posts', [PostController::class, 'index']);

Route::post('/comments',[CommentController::class,'store']);

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/get-all-user', [UserController::class, 'index']);


