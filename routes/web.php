<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Forntend\ForntendController;



// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/',[ForntendController::class, 'index']);
Route::get('/collections',[ForntendController::class, 'categories']);


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
    Route::get('product/{product}/edit',[ProductController::class, 'edit']);
    Route::put('product/{product}',[ProductController::class, 'update']);
    Route::get('product/{product_id}/delete',[ProductController::class, 'destroy']);

    Route::post('product-color/{prdct_color_id}',[ProductController::class, 'updProductQntity']);
    Route::post('product-color/{prdct_color_id}/delete',[ProductController::class, 'deletePrdctColor']);

    Route::get('product-image/{product_image_id}/delete',[ProductController::class, 'destroyImage']);



    // Color Controller
    Route::get('colors',[ColorController::class, 'index']);
    Route::get('colors/create',[ColorController::class, 'create']);
    Route::post('colors',[ColorController::class, 'store']);
    Route::get('colors/{colors}/edit',[ColorController::class, 'edit']);
    Route::put('colors/{colors}',[ColorController::class, 'update']);
    Route::get('colors/{colors_id}/delete',[ColorController::class, 'destroy']);


     // Slider Controller

     Route::get('sliders',[SliderController::class, 'index']);
     Route::get('sliders/create',[SliderController::class, 'create']);
     Route::post('sliders',[SliderController::class, 'store']);
     Route::get('sliders/{sliders}/edit',[SliderController::class, 'edit']);
     Route::put('sliders/{sliders}',[SliderController::class, 'update']);
     Route::get('sliders/{sliders}/delete',[SliderController::class, 'destroy']);

});
