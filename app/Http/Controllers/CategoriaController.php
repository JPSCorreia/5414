<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Listar todas as categorias
    public function index()
    {
        $categorias = Categoria::all();

        return response()->json($categorias);
    }

    // Criar nova categoria
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $categoria = Categoria::create([
            'nome' => $request->nome,
        ]);

        return response()->json($categoria, 201);
    }

    // Atualizar categoria existente
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        $categoria->update([
            'nome' => $request->nome,
        ]);

        return response()->json($categoria);
    }

    // Eliminar categoria
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoria eliminada com sucesso']);
    }
}
