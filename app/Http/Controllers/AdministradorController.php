<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Encomenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\ImagensProduto;

class AdministradorController extends Controller
{
    // Listar pagina de administrador
    public function index(Request $request)
    {
        $query = Utilizador::query();

        // Filtrar por distrito
        if ($request->filled('distrito')) {
            $query->where('distrito', $request->distrito);
        }

        // Filtrar por concelho
        if ($request->filled('concelho')) {
            $query->where('concelho', $request->concelho);
        }

        // Obter utilizadores filtrados
        $utilizadores = $query->get();

        // Obter listas únicas de distritos e concelhos para os filtros
        $distritos = Utilizador::select('distrito')->distinct()->pluck('distrito');
        $concelhos = Utilizador::select('concelho')->distinct()->pluck('concelho');

        // obter categorias
        $categorias = Categoria::all();

        // obter produtos
        $produtos = Produto::all();

        // obter encomendas
        $encomendas = Encomenda::all();

        return view('administrador.index', compact('utilizadores', 'distritos', 'concelhos', 'categorias', 'produtos', 'encomendas'));
    }

}
