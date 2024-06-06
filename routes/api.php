<?php

use App\Http\Controllers\Personal\UserController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(SaleController::class)->group(function(){
    Route::get('/getProduct','getProduct')->name('api.getProduct');
})->middleware('auth::sanctum');
