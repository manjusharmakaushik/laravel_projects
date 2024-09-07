<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Route 
Route::get('/', [AuthController::class, 'index'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [AuthController::class, 'checkAuth'])->name('dashboard');
Route::get('/user-list', [UserController::class, 'index'])->name('user-list');
Route::get('/user-create', [UserController::class, 'create'])->name('user-create');

Route::post('/user-store', [UserController::class, 'store'])->name('user-store');