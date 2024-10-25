<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Utilizador;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EncomendaController extends Controller
{
    // Listar encomendas na página de administrador
    public function index()
    {
        $encomendas = Encomenda::with('utilizador', 'produto')->get();
        $utilizadores = Utilizador::all();
        $produtos = Produto::all();

        return view('administrador.index', compact('encomendas', 'utilizadores', 'produtos'));
    }

    // Criar nova encomenda
    public function store(Request $request)
    {
        $request->validate([
            'utilizador_id' => 'required|exists:utilizadores,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $encomenda = Encomenda::create([
            'utilizador_id' => $request->utilizador_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
        ]);

        return response()->json(['success' => true, 'encomenda' => $encomenda], 201);
    }

    // Atualizar encomenda
    public function update(Request $request, $id)
    {
        $encomenda = Encomenda::find($id);

        if (!$encomenda) {
            return response()->json(['success' => false, 'message' => 'Encomenda não encontrada.'], 404);
        }

        $request->validate([
            'utilizador_id' => 'required|exists:utilizadores,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $encomenda->update([
            'utilizador_id' => $request->utilizador_id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
        ]);

        return response()->json(['success' => true, 'encomenda' => $encomenda]);
    }

    // Apagar encomenda
    public function destroy($id)
    {
        $encomenda = Encomenda::find($id);

        if (!$encomenda) {
            return response()->json(['success' => false, 'message' => 'Encomenda não encontrada.'], 404);
        }

        $encomenda->delete();

        return response()->json(['success' => true]);
    }
}
