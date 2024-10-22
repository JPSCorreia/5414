<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;

class MontraController extends Controller
{
    public function montra()
    {
        Log::info('A tentar Mostrar a Montra de produtos');
        // Procurar todas as categorias com os produtos associados
        $categories = Categoria::with('produtos')->get(); // Usa 'produtos'
    
        return view('montra.montra', compact('categories')); // Passa a variável correta
    }
}
