<?php

use App\Http\Controllers\Personal\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function(){
    Route::get('/person/{ci?}','getPerson')->name('api.getPerson');
});

