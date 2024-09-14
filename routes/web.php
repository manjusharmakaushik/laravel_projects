<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceSectorController;
use App\Http\Controllers\PortfolioCategoryController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceTechCategoryController;
use App\Http\Controllers\ServiceTechController;
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
<<<<<<< Updated upstream
    
      //blog route
      Route::get('/blog-list', [BlogController::class, 'index'])->name('blog-list');
      Route::get('/blog-create', [BlogController::class, 'create'])->name('blog-create');
      Route::post('/blog-store', [BlogController::class, 'store'])->name('blog-store');
      Route::get('blog-edit/{id}', [BlogController::class, 'edit'])->name('blog-edit');
      Route::put('blog-update/{id}', [BlogController::class, 'update'])->name('blog-update');
      Route::get('blog-view/{id}', [BlogController::class, 'view'])->name('blog-view');
      Route::get('blog-delete/{id}', [BlogController::class, 'destory'])->name('blog-delete');
      Route::post('blog-status/{id}', [BlogController::class, 'updateStatus'])->name('updateStatus');
    
=======

    //blog route
    Route::get('/blog-list', [BlogController::class, 'index'])->name('blog-list');
    Route::get('/blog-create', [BlogController::class, 'create'])->name('blog-create');
    Route::post('/blog-store', [BlogController::class, 'store'])->name('blog-store');
    Route::get('blog-edit/{id}', [BlogController::class, 'edit'])->name('blog-edit');
    Route::put('blog-update/{id}', [BlogController::class, 'update'])->name('blog-update');
    Route::get('blog-view/{id}', [BlogController::class, 'view'])->name('blog-view');
    Route::get('blog-delete/{id}', [BlogController::class, 'destory'])->name('blog-delete');
    Route::post('blog-status/{id}', [BlogController::class, 'updateStatus'])->name('updateStatus');

>>>>>>> Stashed changes
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


    // Client Routes Group
    Route::get('/client-list', [ClientController::class, 'index'])->name('client-list');

    Route::get('/client-create', [ClientController::class, 'create'])->name('client-create');
    Route::post('/client-store', [ClientController::class, 'store'])->name('client-store');
    Route::get('/client-edit/{id}', [ClientController::class, 'edit'])->name('client-edit');
    Route::put('/client-update/{id}', [ClientController::class, 'update'])->name('client-update');
    Route::get('/client-view/{id}', [ClientController::class, 'show'])->name('client-view');
    Route::get('/client-delete/{id}', [ClientController::class, 'destroy'])->name('client-delete');
    Route::post('/client-status/{id}', [ClientController::class, 'updateStatus'])->name('client-status');


    // Testimonial Route 
    Route::get('/testimonial-list', [TestimonialController::class, 'index'])->name('testimonial-list');

    Route::get('/testimonial-create', [TestimonialController::class, 'create'])->name('testimonial-create');
    Route::post('/testimonial-store', [TestimonialController::class, 'store'])->name('testimonial-store');
    Route::get('/testimonial-edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial-edit');
    Route::put('/testimonial-update/{id}', [TestimonialController::class, 'update'])->name('testimonial-update');
    Route::get('/testimonial-view/{id}', [TestimonialController::class, 'show'])->name('testimonial-view');
    Route::get('/testimonial-delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonial-delete');
    Route::post('/testimonial-status/{id}', [TestimonialController::class, 'updateStatus'])->name('testimonial-status');



    //Portfolio 
    Route::get('/portfolio-list', [PortfolioController::class, 'index'])->name('portfolio-list');
    Route::get('/portfolio-create', [PortfolioController::class, 'create'])->name('portfolio-create');
    Route::post('/portfolio-store', [PortfolioController::class, 'store'])->name('portfolio-store');
    Route::get('portfolio-edit/{id}', [PortfolioController::class, 'edit'])->name('portfolio-edit');
    Route::put('portfolio-update/{id}', [PortfolioController::class, 'update'])->name('portfolio-update');
    Route::get('portfolio-view/{id}', [PortfolioController::class, 'view'])->name('portfolio-view');
    Route::get('portfolio-delete/{id}', [PortfolioController::class, 'destory'])->name('portfolio-delete');
    Route::post('portfolio-status/{id}', [PortfolioController::class, 'updatePortStatus'])->name('updatePortStatus');

    //service Tech category
    Route::get('/service-tech-cat-list', [ServiceTechCategoryController::class, 'index'])->name('service-tech-cat-list');
    Route::get('/service-tech-cat-create', [ServiceTechCategoryController::class, 'create'])->name('service-tech-cat-create');
    Route::post('/service-tech-cat-store', [ServiceTechCategoryController::class, 'store'])->name('service-tech-cat-store');
    Route::get('service-tech-cat-edit/{id}', [ServiceTechCategoryController::class, 'edit'])->name('service-tech-cat-edit');
    Route::put('service-tech-cat-update/{id}', [ServiceTechCategoryController::class, 'update'])->name('service-tech-cat-update');
    Route::get('service-tech-cat-view/{id}', [ServiceTechCategoryController::class, 'view'])->name('service-tech-cat-view');
    Route::get('service-tech-cat-delete/{id}', [ServiceTechCategoryController::class, 'destory'])->name('service-tech-cat-delete');
    Route::post('service-tech-cat-status/{id}', [ServiceTechCategoryController::class, 'updateStatus'])->name('updateStatus');

    //service tech
    Route::get('/service-tech-list', [ServiceTechController::class, 'index'])->name('service-tech-list');
    Route::get('/service-tech-create', [ServiceTechController::class, 'create'])->name('service-tech-create');
    Route::post('/service-tech-store', [ServiceTechController::class, 'store'])->name('service-tech-store');
    Route::get('service-tech-edit/{id}', [ServiceTechController::class, 'edit'])->name('service-tech-edit');
    Route::put('service-tech-update/{id}', [ServiceTechController::class, 'update'])->name('service-tech-update');
    Route::get('service-tech-view/{id}', [ServiceTechController::class, 'view'])->name('service-tech-view');
    Route::get('service-tech-delete/{id}', [ServiceTechController::class, 'destory'])->name('service-tech-delete');
    Route::post('service-tech-status/{id}', [ServiceTechController::class, 'updateStatus'])->name('updateStatus');
});
