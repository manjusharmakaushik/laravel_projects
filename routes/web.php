<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

});
