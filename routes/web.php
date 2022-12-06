<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NewsfeedController;
use App\Http\Controllers\UserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'loginPage']);

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('login',[AuthController::class,'login'])->name('login.auth');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);

Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('reset-password.submit');


Route::prefix('admin')->middleware('auth:admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart-data', [DashboardController::class, 'index'])->name('chart-data');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
    Route::post('profileupdate',[AuthController::class,'profileupdate'])->name('profileupdate');

    Route::view('/change-password','account.changepassword')->name('changepassword');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('update-password');



    Route::get('/sub-admins', [AdminController::class, 'index'])->name('admin.list');
    Route::post('/sub-admins', [AdminController::class, 'create'])->name('admin.create');

    Route::get('/sub-admins/{admin}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::delete('/sub-admins/{admin}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::post('/sub-admins/update',[AdminController::class,'update'])->name('admin.update');
    Route::post('/adminpassword',[AdminController::class,'changepassword'])->name('admin.password');

    Route::prefix('faq')->group(function(){
        Route::get('/', [FaqController::class, 'index'])->name('admin.faq');
        Route::post('/', [FaqController::class, 'create'])->name('faq.create');
        Route::get('/{faq}', [FaqController::class, 'edit'])->name('faq.edit');
        Route::post('/{faq}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('faq.delete');
     });

    Route::get('/contact-us', [ContactusController::class, 'index'])->name('contactus');



    Route::prefix('/users')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('user.list');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('user.delete');
        Route::post('{id}/change-status', [UserController::class, 'changeStatus'])->name('user.status');
        Route::get('{id}/sub-projects', [UserController::class, 'subproject'])->name('user.subproject');
        Route::get('{id}', [UserController::class, 'view'])->name('user.view');
        Route::get('{id}/view-sub-projects', [UserController::class, 'viewsubproject'])->name('user.viewsubproject');
        Route::get('{id}/view-donation', [UserController::class, 'viewdonation'])->name('user.viewdonation');
    });

    Route::prefix('projects')->group(function(){
        Route::get('/', [ProjectController::class, 'index'])->name('admin.projects');
        Route::get('/create', [ProjectController::class, 'create'])->name('admin.projects.create');
        Route::post('/create', [ProjectController::class, 'store'])->name('admin.projects.submit');
        Route::get('{project}', [ProjectController::class, 'edit'])->name('admin.projects.edit');
        Route::post('{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
        Route::delete('{id}', [ProjectController::class, 'destroy'])->name('admin.projects.delete');
        Route::post('{id}/change-status', [ProjectController::class, 'changeStatus'])->name('admin.projects.status');
        Route::get('{id}/view', [ProjectController::class, 'view'])->name('admin.projects.view');
        Route::get('/{id}/news-feeds', [ProjectController::class, 'newsFeeds'])->name('admin.projects.newsfeed');
        Route::post('/{id}/news-feeds', [ProjectController::class, 'addNewsFeed'])->name('admin.projects.newsfeed.create');

        Route::get('{project}/sub-projects', [ProjectController::class, 'subProjects'])->name('admin.projects.sub-projects');
        Route::get('{project}/viewsub-projects', [ProjectController::class, 'viewsubProjects'])->name('admin.projects.viewsub-projects');
        Route::get('/{id}/viewnews-feeds', [ProjectController::class, 'viewnewsFeeds'])->name('admin.projects.viewnewsfeed');
    });

    Route::prefix('sub-projects')->group(function(){
        Route::get('/', [ProjectController::class, 'allSubProjects'])->name('admin.sub-projects');
        Route::get('/{id}/edit', [ProjectController::class, 'editSubProject'])->name('admin.sub-projects.edit');
        Route::post('/{project}/edit', [ProjectController::class, 'updateSubProject'])->name('admin.sub-projects.update');
    });

    Route::prefix('news-feeds')->group(function(){
        Route::get('/', [NewsfeedController::class, 'index'])->name('admin.newsfeed');
        Route::post('/', [NewsfeedController::class, 'create'])->name('admin.newsfeed.create');
        Route::get('/{newsfeed}', [NewsfeedController::class, 'edit'])->name('admin.newsfeed.edit');
        Route::post('/{newsfeed}', [NewsfeedController::class, 'update'])->name('admin.newsfeed.update');
        Route::delete('/{newsfeed}', [NewsfeedController::class, 'destroy'])->name('admin.newsfeed.delete');
    });


    Route::get('donation',[DonationController::class, 'index'])->name('donation.list');

    Route::prefix('legal')->group(function(){
        Route::get('{type}', [LegalController::class, 'edit'])->name('legal.edit');
        Route::post('/', [LegalController::class, 'update'])->name('legal.update');
    });
});




Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-and-conditions', 'terms-and-condition');
