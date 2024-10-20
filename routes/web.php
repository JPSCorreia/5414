<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PerfilController;


Route::get('/', [HomeController::class, 'index']); // Homepage

Route::get('/administrador', [AdministradorController::class, 'index'])->middleware('auth'); // Lista todos os utilizadores

Route::get('produtos', [ProdutoController::class, 'index']); // Lista todos os produtos

Route::get('/categorias', [CategoriaController::class, 'index']); // Lista todas as categorias

Route::get('/categorias/{id}', [CategoriaController::class, 'show']); // Mostra os produtos de uma categoria específica

Route::get('/register', [AuthController::class, 'showRegisterForm']); // Formulário de registo

Route::post('/register', [AuthController::class, 'register']); // Registo

Route::get('/login', [AuthController::class, 'showLoginForm']); // Formulário de login

Route::post('/login', [AuthController::class, 'login']); // Login

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth'); // Logout

Route::put('/utilizadores/{id}/editar', [AdministradorController::class, 'update'])->middleware('auth'); // Editar utilizador

Route::put('/perfil/actualizar', [PerfilController::class, 'actualizar']); // Actualizar perfil

Route::post('/administrador/create', [AdministradorController::class, 'create']); // Cria um novo utilizador

Route::delete('/administrador/{id}/delete', [AdministradorController::class, 'destroy']); // Elimina um utilizador

Route::put('/perfil/alterar_password', [PerfilController::class, 'alterarPassword']); // Alterar password

Route::post('/categorias/store', [CategoriaController::class, 'store']); // Cria uma nova categoria

Route::post('/categorias/{id}/update', [CategoriaController::class, 'update']); // Edita uma categoria

Route::delete('/categorias/{id}/destroy', [CategoriaController::class, 'destroy']); // Elimina uma categoria


Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth');



// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });
