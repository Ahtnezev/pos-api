<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas (registro y login)
Route::post('/register', [AuthController::class, 'register']);
//~ Logea el usuario y nos devuelve un token
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
//~ Para cerrar sesión, el usuario debe estar autenticado
//~ (éste nos dará un token el cual agregaremos en los Headers del cliente, en este caso Postman: Authorization: Bearer <token>)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
