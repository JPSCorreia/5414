<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// // Utilizadores
// // GET /utilizadores
// Route::get('/utilizadores', [UserController::class, 'index']);

// // GET /utilizadores/{id}
// Route::get('/utilizadores/{id}', [UserController::class, 'show']);

// // POST /utilizadores
// Route::post('/utilizadores', [UserController::class, 'store']);

// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });