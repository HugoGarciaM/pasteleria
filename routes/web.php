<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('main');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/t', function(){
    return view('t');
});

Route::middleware('auth')->prefix('admin')->group(base_path('routes/admin.php'));
Route::middleware('auth')->group(function(){
    Route::post('/paymentQR',[PaymentController::class,'generateQR'])->name('paymentQR');
    Route::post('/statusQR',[PaymentController::class,'verifyQR'])->name('statusQR');

    Route::get('/payments/desactive',[SaleController::class,'desactiveTransaction'])->name('payments.desactive');

    Route::get('/payments',function(){
        return view('customerPayment');
    })->name('payments');
});
?>
