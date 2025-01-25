<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Customer routes
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/plans', [SubscriptionController::class, 'showPlans']);
//     Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
//     Route::get('/invoice/{userId}', [SubscriptionController::class, 'generateInvoice']);
// });

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/customers', [AdminController::class, 'listCustomers']);
    Route::put('/admin/customers/{id}', [AdminController::class, 'updateCustomer']);
    Route::post('/admin/customers/{id}/deactivate', [AdminController::class, 'deactivateCustomer']);
    Route::post('/admin/customers/{id}/reactivate', [AdminController::class, 'reactivateCustomer']);
    Route::delete('/admin/customers/{id}', [AdminController::class, 'deleteCustomer']);
});
