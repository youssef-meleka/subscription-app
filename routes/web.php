<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/admin/customers', [AdminController::class, 'listCustomers'])->name('admin.customers.index');
Route::get('/admin/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('admin.customers.edit');
Route::put('/admin/customers/{id}', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
Route::post('/admin/customers/{id}/deactivate', [AdminController::class, 'deactivateCustomer'])->name('admin.customers.deactivate');
Route::post('/admin/customers/{id}/reactivate', [AdminController::class, 'reactivateCustomer'])->name('admin.customers.reactivate');
Route::delete('/admin/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customers.destroy');
