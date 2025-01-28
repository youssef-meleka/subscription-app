<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Show payment form
Route::get('/payment', [SubscriptionController::class, 'showPaymentForm'])->name('payment.form');

// Handle subscription
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

// Success page - print invoice
Route::view('/success', 'invoice')->name('success');
