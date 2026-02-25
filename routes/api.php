<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityEventController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFriendController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Resources\UserResource;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('cookie_auth')->prefix('social-media')->group(function () {
    Route::post('/user/logout', [UserController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return new UserResource(auth()->user());
    });

    Route::group(['prefix' => 'user-photos'], function () {

        Route::post('/', [UserPhotoController::class, 'store']);
        Route::get('/', [UserPhotoController::class, 'index']);
    });

    Route::group(['prefix' => 'friends'], function () {

        Route::post('/send-request', [UserFriendController::class, 'sendFriendRequest']);
        Route::post('/accept', [UserFriendController::class, 'acceptFriendRequest']);
        Route::get('/', [UserFriendController::class, 'listFriends']);
        Route::get('/requests', [UserFriendController::class, 'listFriendRequests']);
        Route::get('/pending', [UserFriendController::class, 'listPending']);

    });

    Route::group(['prefix' => 'story'], function () {

        Route::get('/', [StoryController::class, 'index']);
        Route::post('/', [StoryController::class, 'store']);
    });

    Route::post('/post', [PostController::class, 'store']);
    Route::get('/post/{post}', [PostController::class, 'show']);

    Route::get('/feed', [FeedController::class, 'index']);

    Route::group(['prefix' => 'community'], function () {
        Route::post('/', [CommunityController::class, 'store']);
        Route::get('/', [CommunityController::class, 'index']);
        Route::get('/{community}', [CommunityController::class, 'show']);
    });

    Route::group(['prefix' => 'community-event'], function () {

        Route::post('/', [CommunityEventController::class, 'store']);
        Route::get('/', [CommunityEventController::class, 'index']);
        Route::get('/random-event', [CommunityEventController::class, 'show']);
    });
});

Route::get('/category', [CategoryController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'store']);
});


Route::get('/health', function () {
    return response()->json(['status' => 'Api is running']);
});
