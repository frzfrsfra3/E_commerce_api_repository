<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Actions\UserLoginAction;
use App\Actions\RegisterUserAction;
use App\Actions\UserRegisterAction;

use App\Actions\ProductActions\CreateProductAction;
use App\Actions\ProductActions\UpdateProductAction;
use App\Actions\ProductActions\DeleteProductAction;
use App\Actions\ProductActions\GetProductAction;
use App\Actions\ProductActions\ListProductsAction;
use App\Actions\CreateOrderAction;
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



Route::post('login', UserLoginAction::class);
Route::post('register', UserRegisterAction::class);
Route::middleware('auth:api')->group(function () {
    Route::post('products', CreateProductAction::class);
    Route::post('products/{id}', UpdateProductAction::class);
    Route::delete('products/{id}', DeleteProductAction::class);
    Route::get('products/{id}', GetProductAction::class);
    Route::get('products', ListProductsAction::class);
    Route::post('orders', CreateOrderAction::class);
});

