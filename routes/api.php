<?php

use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\OrderApiController;
use Illuminate\Support\Facades\Route;

Route::get('/menu', [MenuApiController::class, 'index']);
Route::get('/menu/{id}', [MenuApiController::class, 'show'])->whereNumber('id');
Route::post('/orders', [OrderApiController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/orders/{order}', [OrderApiController::class, 'show'])->whereNumber('order');
});
