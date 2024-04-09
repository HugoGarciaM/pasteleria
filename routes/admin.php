<?php

use App\Http\Controllers\Personal\DashboardController;
use App\Http\Controllers\Personal\Admin\CategoryController;
use App\Http\Controllers\Personal\Admin\ProductController;
use App\Http\Controllers\Personal\Admin\ProductDayController;
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
    Route::put('/product/update/{product}','update')->name('admin.product.update');
    Route::post('/product/delete/{product}','delete')->name('admin.product.delete');
    Route::get('/product/img/{id}','showImg')->name('admin.product.img');
});

Route::controller(ProductDayController::class)->group(function(){
    Route::post('/date','newBatch')->name('admin.batch.create');
    Route::post('/date/product/create/{date}','create')->name('admin.batch.product.create');
    Route::post('/date/product/delete/{id}','delete')->name('admin.batch.product.delete');
    Route::post('/date/product/update/{detail}','update')->name('admin.batch.product.update');
});


?>
