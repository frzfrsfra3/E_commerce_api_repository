<?php

use App\Actions\LoginUserAction;
use App\Actions\RegisterUserAction;
use App\Actions\ProductAction;
use App\Actions\CreateOrderAction;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterUserAction::class);
Route::post('login', LoginUserAction::class);

Route::middleware('auth:api')->group(function () {
    Route::get('products', [ProductAction::class, 'index']);
    Route::post('products', [ProductAction::class, 'store']);
    Route::put('products/{id}', [ProductAction::class, 'update']);
    Route::delete('products/{id}', [ProductAction::class, 'destroy']);

    Route::post('orders', CreateOrderAction::class);
});