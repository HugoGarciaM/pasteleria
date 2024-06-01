<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('admin')->group(base_path('routes/admin.php'));


?>
