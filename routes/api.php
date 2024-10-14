<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Utilizadores
// GET /utilizadores
Route::get('/utilizadores', [UserController::class, 'index']);

// GET /utilizadores/{id}
Route::get('/utilizadores/{id}', [UserController::class, 'show']);

// POST /utilizadores
Route::post('/utilizadores', [UserController::class, 'store']);

