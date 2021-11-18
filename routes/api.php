<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('websites', [WebsiteController::class,'index']);
Route::post('websites', [WebsiteController::class,'store']);
Route::post('websites/{id}', [WebsiteController::class,'update']);

Route::get('posts', [PostController::class,'index']);
Route::post('posts', [PostController::class,'store']);
Route::post('posts/{id}', [PostController::class,'update']);

Route::get('subscriptions', [SubscriptionController::class,'index']);
Route::post('subscriptions/subscribe', [SubscriptionController::class,'subscribe']);
Route::post('subscriptions/unsubscribe', [SubscriptionController::class,'unsubscribe']);
