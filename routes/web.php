<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilizadorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/utilizadores', [UtilizadorController::class, 'index']);

// // Utilizadores
// // GET /utilizadores
// Route::get('/utilizadores', [UtilizadorController::class, 'index']);

// // GET /utilizadores/{id}
// Route::get('/utilizadores/{id}', [UtilizadorController::class, 'show']);

// // POST /utilizadores
// Route::post('/utilizadores', [UtilizadorController::class, 'store']);

// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });