<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;

class HomeController extends Controller
{
    public function index()
    {
        // Obter categorias e produtos da base de dados
        $categorias = Categoria::all();
        $produtos = Produto::with('imagens')->get();

        // Passar as variáveis para a view
        return view('index', compact('categorias', 'produtos'));
    }
}
