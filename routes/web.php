<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MontraController;
use App\Http\Controllers\EncomendaController;

Route::get('/', [HomeController::class, 'index']); // Homepage
Route::get('/administrador', [AdministradorController::class, 'index'])->middleware('auth'); // Lista todos os utilizadores
//Route::get('produtos', [ProdutoController::class, 'index']); // Lista todos os produtos

Route::prefix('produtos')->group(function () {
    // Listar todos os produtos
    Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index');

    // Criar novo produto (GET para a view de criar)
    Route::get('/criar', [ProdutoController::class, 'create'])->name('produtos.create');

    // Mostrar um produto específico
    Route::get('/{id}', [ProdutoController::class, 'show'])->name('produtos.show');

    // Editar produto (GET para a view de editar)
    Route::get('/{id}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');

    // Armazenar novo produto
    Route::post('/', [ProdutoController::class, 'store'])->name('produtos.store');

    // Atualizar produto existente
    Route::put('/{id}', [ProdutoController::class, 'update'])->name('produtos.update');

    // Eliminar produto existente
    Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
});


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
Route::get('/montra', [MontraController::class, 'montra'])->name('montra.index'); //mostra a montra de categorias
Route::prefix('administrador')->name('administrador.')->group(function() {
    // Rota para a listagem de encomendas
    Route::get('/encomendas', [EncomendaController::class, 'index'])->name('encomendas.index')->middleware('auth');
    // Rota para editar uma encomenda específica
    Route::get('/encomendas/{id}/edit', [EncomendaController::class, 'edit'])->name('encomendas.edit')->middleware('auth');
    // Rota para atualizar uma encomenda específica
    Route::put('/encomendas/{id}', [EncomendaController::class, 'update'])->name('encomendas.update')->middleware('auth');
});
Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth');
// Get CSRF Token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });