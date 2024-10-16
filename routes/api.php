<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilizadorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ImagemProdutoController;
use App\Http\Controllers\CategoriaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Utilizadores
// GET /utilizadores
Route::get('/utilizadores', [UtilizadorController::class, 'index']);
// GET /utilizadores/{id}
Route::get('/utilizadores/{id}', [UtilizadorController::class, 'show']);
// POST /utilizadores
Route::post('/utilizadores', [UtilizadorController::class, 'store']);
// PUT /utilizadores/{id}
Route::put('/utilizadores/{id}', [UtilizadorController::class, 'update']);
// DELETE /utilizadores/{id}
Route::delete('/utilizadores/{id}', [UtilizadorController::class, 'destroy']);

// Produtos
// GET /produtos
Route::get('/produtos', [ProdutoController::class, 'index']);
// GET /produtos/{id}
Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
// POST /produtos
Route::post('/produtos', [ProdutoController::class, 'store']);
// PUT /produtos/{id}
Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
// DELETE /produtos/{id}
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

// Categorias
// GET /categorias
Route::get('/categorias', [CategoriaController::class, 'index']);
// GET /categorias/{id}
Route::post('/categorias', [CategoriaController::class, 'store']);
// PUT /categorias/{id}
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
// DELETE /categorias/{id}
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

// Imagens de um produto
// GET /produtos/{produto_id}/imagens
Route::get('/produtos/{produto_id}/imagens', [ImagemProdutoController::class, 'index']);
// POST /produtos/{produto_id}/imagens
Route::post('/produtos/{produto_id}/imagens', [ImagemProdutoController::class, 'store']);
// PUT /produtos/{id}/imagens/{id}
Route::put('/imagens/{id}', [ImagemProdutoController::class, 'update']);
// DELETE /produtos/{id}/imagens/{id}
Route::delete('/imagens/{id}', [ImagemProdutoController::class, 'destroy']);