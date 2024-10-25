<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UtilizadorController;
use App\Http\Controllers\CarrinhoController;

// Home
Route::get('/', [HomeController::class, 'index']); // Página inicial

// Produtos
Route::get('produtos', [ProdutoController::class, 'index']); // Página de produtos
Route::get('produtos/{id}', [ProdutoController::class, 'show']); // Página de um produto com id especifico
Route::post('/administrador/produtos/store', [ProdutoController::class, 'store'])->name('produtos.store'); // Cria um novo produto
Route::put('/administrador/produtos/{id}/update', [ProdutoController::class, 'update']); // Editar um produto

Route::delete('/administrador/produtos/{id}/destroy', [ProdutoController::class, 'destroy']); // Eliminar um produto

// Administrador
Route::get('/administrador', [AdministradorController::class, 'index'])->middleware('auth'); // Página de administrador

// Categorias
Route::get('/categorias', [CategoriaController::class, 'index']); // Página de categorias
Route::get('/categorias/{id}', [CategoriaController::class, 'show']); // Página de uma categoria com id especifico
Route::post('/administrador/categorias/store', [CategoriaController::class, 'store']); // Cria uma nova categoria
Route::put('/administrador/categorias/{id}/update', [CategoriaController::class, 'update']); // Editar categoria
Route::delete('/administrador/categorias/{id}/destroy', [CategoriaController::class, 'destroy']); // Eliminar categoria

// Autenticação
Route::get('/register', [AuthController::class, 'showRegisterForm']); // Pagina de registo de utilizador
Route::get('/login', [AuthController::class, 'showLoginForm']); // Página de login
Route::post('/register', [AuthController::class, 'register']); // Criar novo utilizador
Route::post('/login', [AuthController::class, 'login']); // Fazer login
Route::post('/logout', [AuthController::class, 'logout']); // Fazer logout

// Utilizadores
Route::post('administrador/utilizadores/store', [UtilizadorController::class, 'store'])->middleware('auth'); // Cria um novo utilizador
Route::put('/administrador/utilizadores/{id}/update', [UtilizadorController::class, 'update'])->middleware('auth'); // Editar utilizador
Route::delete('/administrador/utilizadores/{id}/destroy', [UtilizadorController::class, 'destroy'])->middleware('auth'); // Elimina um utilizador

// Perfil
Route::get('/perfil', [PerfilController::class, 'index'])->middleware('auth'); // Página de perfil
Route::put('/perfil/actualizar', [PerfilController::class, 'actualizar']); // Actualizar perfil
Route::put('/perfil/alterar_password', [PerfilController::class, 'alterarPassword']); // Alterar password

// Carrinho
Route::get('/carrinho', [CarrinhoController::class, 'index'])->middleware('auth'); // Página de carrinho
Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->middleware('auth'); // Adicionar ao carrinho
Route::post('/carrinho/actualizar', [CarrinhoController::class, 'actualizar'])->middleware('auth'); // Actualizar
Route::post('/carrinho/remover', [CarrinhoController::class, 'remover'])->middleware('auth'); // Remover
Route::post('/carrinho/encomendar', [CarrinhoController::class, 'encomendar'])->middleware('auth'); // Encomendar

// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });
