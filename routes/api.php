<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/new', [\App\Http\Controllers\Api\OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/update', [\App\Http\Controllers\Api\OrderController::class, 'update'])->name('orders.update');

