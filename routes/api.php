<?php

use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DriverController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('get-token', [AuthController::class, 'getToken']);

Route::middleware('drivers')->group(function () {
    Route::post('send-location', [DriverController::class, 'sendLocation']);
    Route::post('orders/assign/{order}', [OrderController::class, 'assign']);
    Route::post('orders/delivered/{order}', [OrderController::class, 'delivered']);
});

Route::middleware('customers')->group(function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/cancel/{order}', [OrderController::class, 'cancel']);
});

