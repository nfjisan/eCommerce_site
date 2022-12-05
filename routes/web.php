<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){

    Route::get('dashboard',[DashboardController::class, 'index']);

    // category route

    Route::get('category',[CategoryController::class, 'index']);
    Route::get('category/create',[CategoryController::class, 'create']);
    Route::post('category',[CategoryController::class, 'store']);
    Route::get('category/{category}/edit',[CategoryController::class, 'edit']);
    Route::put('category/{category}',[CategoryController::class, 'update']);

    // brand route

    Route::get('brand',App\Http\Livewire\Admin\Brand\Index::class);

    // ProductController
    Route::get('product',[ProductController::class, 'index']);
    Route::get('product/create',[ProductController::class, 'create']);
    Route::post('product',[ProductController::class, 'store']);
});
