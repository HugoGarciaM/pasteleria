<?php

use App\Http\Controllers\Personal\DashboardController;
use App\Http\Controllers\Personal\Admin\CategoryController;
use App\Http\Controllers\Personal\Admin\ProductController;
use Illuminate\Support\Facades\Route;


Route::controller(DashboardController::class)->group(function(){
    Route::get('/','index')->name('admin');
    Route::get('/batch','batch')->name('admin.batch');
    Route::get('/product','product')->name('admin.product');
});


Route::controller(CategoryController::class)->group(function(){
    Route::post('/category','create')->name('admin.category.create');
    Route::put('/category/update/{category}','update')->name('admin.category.update');
    Route::post('/category/delete/{category}','delete')->name('admin.category.delete');
});


Route::controller(ProductController::class)->group(function(){
    Route::post('/product','create')->name('admin.product.create');
});


?>
