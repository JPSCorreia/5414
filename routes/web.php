<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilizadorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;


Route::get('/', [HomeController::class, 'index']); // Homepage

Route::get('/utilizadores', [UtilizadorController::class, 'index']); // Lista todos os utilizadores

Route::get('produtos', [ProdutoController::class, 'index']); // Lista todos os produtos

Route::get('/categorias', [CategoriaController::class, 'index']); // Lista todas as categorias

Route::get('/categorias/{id}', [CategoriaController::class, 'show']); // Mostra os produtos de uma categoria específica

Route::get('/register', [AuthController::class, 'showRegisterForm']); // Formulário de registo

Route::post('/register', [AuthController::class, 'register']); // Registo

Route::get('/login', [AuthController::class, 'showLoginForm']); // Formulário de login

Route::post('/login', [AuthController::class, 'login']); // Login

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth'); // Logout

Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth');



// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });