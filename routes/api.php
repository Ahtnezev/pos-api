<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

// Rutas públicas (registro y login)
Route::post('/register', [AuthController::class, 'register']);
//~ Logea el usuario y nos devuelve un token
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    //~ Para cerrar sesión, el usuario debe estar autenticado
    //~ (éste nos dará un token el cual agregaremos en los Headers del cliente, en este caso Postman: Authorization: Bearer <token>)
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('stores', StoreController::class);
    Route::apiResource('stores.products', ProductController::class)->shallow();
    Route::post('cart', [CartController::class, 'store']);
    Route::post('cart/checkout', [CartController::class, 'checkout']);
    Route::delete('cart/detail/{cartDetailId}/', [CartController::class, 'destroyDetail']);

});
