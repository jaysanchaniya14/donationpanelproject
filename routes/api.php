<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\NewsFeedController;
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

Route::post('sign-up', [AuthController::class, 'register']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);

Route::post('social-login', [AuthController::class, 'socialLogin']);
Route::post('social-register', [AuthController::class, 'socialRegister']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('profile', [UserController::class, 'updateProfile']);

    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::post('deactivate-account', [UserController::class, 'deactivateAccount']);
    Route::post('delete-account', [UserController::class, 'deleteAccount']);
    Route::post('change-email', [UserController::class, 'changeEmail']);
    Route::post('verify-email', [UserController::class, 'verifyEmail']);

    Route::prefix('user/projects')->group(function(){
        Route::get('/', [ProjectController::class, 'userProjects']);
        Route::post('/', [ProjectController::class, 'createSubProject']);
        Route::delete('{project}', [ProjectController::class, 'destroy']);
        Route::post('{project}', [ProjectController::class, 'update']);
    });

    Route::post('currencies', [DonationController::class, 'updateCurrency']);

    Route::get('logout', [AuthController::class, 'logout']);
});

Route::get('explore', [ProjectController::class, 'explore']);

Route::prefix('projects')->group(function(){
    Route::get('', [ProjectController::class, 'index']);
    Route::get('{project}/newsfeed', [ProjectController::class, 'newsFeed']);
    Route::get('{project}/donations', [DonationController::class, 'donations']);
});

Route::prefix('newsfeeds')->group(function (){
    Route::get('', [NewsFeedController::class, 'index']);
    Route::post('{newsfeed}/like', [NewsFeedController::class, 'likeNewsFeed'])->middleware('auth:sanctum');
});

Route::get('user/donations', [DonationController::class, 'index']);
Route::get('user/donations/{donation}/invoice', [DonationController::class, 'getInvoice']);

Route::get('guest-data', [UserController::class, 'guestData']);
Route::get('statistics', [ProjectController::class, 'statistics']);
Route::get('leaderboard', [DonationController::class, 'leaderBoard']);

Route::post('contact-us', [UserController::class, 'contactUs']);

Route::get('currencies', [DonationController::class, 'getCurrencies']);
Route::get('currencies/rate', [DonationController::class, 'currencyRate'])->middleware('throttle:10,1');
Route::get('legals', [FaqController::class, 'getLegals']);
Route::get('faqs', [FaqController::class, 'getFAQs']);
