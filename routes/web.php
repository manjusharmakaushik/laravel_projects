<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceSectorController;
use App\Http\Controllers\PortfolioCategoryController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('content.authentications.auth-login-basic');
})->name('login');

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login-check', [AuthController::class, 'loginCheck'])->name('loginCheck');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'checkAuth'])->name('dashboard');
    Route::get('/user-list', [UserController::class, 'index'])->name('user-list');
    Route::get('/user-create', [UserController::class, 'create'])->name('user-create');
    Route::post('/user-store', [UserController::class, 'store'])->name('user-store');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('user-edit');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('user-update');
    Route::get('user-view/{id}', [UserController::class, 'view'])->name('user-view');
    Route::get('user-delete/{id}', [UserController::class, 'destory'])->name('user-delete');
    Route::post('user-status/{id}', [UserController::class, 'updateStatus'])->name('updateStatus');
    
      //blog route
      Route::get('/blog-list', [BlogController::class, 'index'])->name('blog-list');
      Route::get('/blog-create', [BlogController::class, 'create'])->name('blog-create');
      Route::post('/blog-store', [BlogController::class, 'store'])->name('blog-store');
      Route::get('blog-edit/{id}', [BlogController::class, 'edit'])->name('blog-edit');
      Route::put('blog-update/{id}', [BlogController::class, 'update'])->name('blog-update');
      Route::get('blog-view/{id}', [BlogController::class, 'view'])->name('blog-view');
      Route::get('blog-delete/{id}', [BlogController::class, 'destory'])->name('blog-delete');
      Route::post('blog-status/{id}', [BlogController::class, 'updateStatus'])->name('updateStatus');
    
    //service category
    Route::get('/service-list', [ServiceController::class, 'index'])->name('service-list');
    Route::get('/service-create', [ServiceController::class, 'create'])->name('service-create');
    Route::post('/service-store', [ServiceController::class, 'store'])->name('service-store');
    Route::get('service-edit/{id}', [ServiceController::class, 'edit'])->name('service-edit');
    Route::put('service-update/{id}', [ServiceController::class, 'update'])->name('service-update');
    Route::get('service-view/{id}', [ServiceController::class, 'view'])->name('service-view');
    Route::get('service-delete/{id}', [ServiceController::class, 'destory'])->name('service-delete');
    Route::post('service-status/{id}', [ServiceController::class, 'updateStatus'])->name('updateStatus');

    //service sector
    Route::get('/service-sector-list', [ServiceSectorController::class, 'index'])->name('sector-list');
    Route::get('/sector-create', [ServiceSectorController::class, 'create'])->name('sector-create');
    Route::post('/sector-store', [ServiceSectorController::class, 'store'])->name('sector-store');
    Route::get('sector-edit/{id}', [ServiceSectorController::class, 'edit'])->name('sector-edit');
    Route::put('sector-update/{id}', [ServiceSectorController::class, 'update'])->name('sector-update');
    Route::get('sector-view/{id}', [ServiceSectorController::class, 'view'])->name('sector-view');
    Route::get('sector-delete/{id}', [ServiceSectorController::class, 'destory'])->name('sector-delete');
    Route::post('sector-status/{id}', [ServiceSectorController::class, 'updateStatus'])->name('updateStatus');
    //portfolio category
    Route::get('/portfolio-cat-list', [PortfolioCategoryController::class, 'index'])->name('portfolio-cat-list');

    Route::get('/portfolio-cat-create', [PortfolioCategoryController::class, 'create'])->name('portfolio-cat-create');
    Route::post('/portfolio-cat-store', [PortfolioCategoryController::class, 'store'])->name('portfolio-cat-store');
    Route::get('portfolio-cat-edit/{id}', [PortfolioCategoryController::class, 'edit'])->name('portfolio-cat-edit');
    Route::put('portfolio-cat-update/{id}', [PortfolioCategoryController::class, 'update'])->name('portfolio-cat-update');
    Route::get('portfolio-cat-view/{id}', [PortfolioCategoryController::class, 'view'])->name('portfolio-cat-view');
    Route::get('portfolio-cat-delete/{id}', [PortfolioCategoryController::class, 'destory'])->name('portfolio-cat-delete');
    Route::post('portfolio-cat-status/{id}', [PortfolioCategoryController::class, 'updateStatus'])->name('updateStatus');
});
