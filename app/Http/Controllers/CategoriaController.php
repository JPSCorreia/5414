<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    // Listar todas as categorias
    public function index()
    {

        Log::info('A tentar encontrar todas as categorias');

        $categorias = Categoria::all();

        Log::info('Categorias encontradas com sucesso.');

        // Verify if the request expects JSON
        if (request()->wantsJson()) {
            Log::info('A tentar retornar as categorias como JSON');
            return response()->json($categorias);
        }

        Log::info('A tentar retornar as categorias como HTML');

        return view('categorias.index', ['categorias' => $categorias]);
    }

    // Mostrar uma categoria específica
    public function show($id)
    {
        Log::info('A tentar encontrar a categoria: ' . $id);

        $categoria = Categoria::find($id);

        if (!$categoria) {
            Log::error('Categoria com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Categoria nao encontrada'], 404);
        }

        Log::info('Categoria encontrada: ' . $id);

        if (request()->wantsJson()) {
            return response()->json($categoria);
        }

        return view('categorias.show', ['categoria' => $categoria]);
    }

    // Criar nova categoria
    public function store(Request $request)
    {
        Log::info('A tentar criar uma nova categoria, a validar dados enviados no request: ', $request->all());

        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Log::info('Dados validados com sucesso, a tentar criar nova categoria...');

        $categoria = Categoria::create([
            'nome' => $request->nome,
        ]);

        Log::info('Categoria criada com sucesso: ' . $request->nome);

        return response()->json($categoria, 201);
    }

    // Atualizar categoria existente
    public function update(Request $request, $id)
    {
        Log::info('A tentar atualizar a categoria com ID: ' . $id);

        $categoria = Categoria::find($id);

        if (!$categoria) {
            Log::error('Categoria com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        Log::info('A tentar validar dados enviados no request: ', $request->all());

        $categoria->update([
            'nome' => $request->nome,
        ]);

        Log::info('Categoria atualizada com sucesso: ' . $request->nome);

        return response()->json($categoria);
    }

    // Eliminar categoria
    public function destroy($id)
    {
        Log::info('A tentar encontrar e eliminar a categoria com ID: ' . $id);

        $categoria = Categoria::find($id);

        if (!$categoria) {
            Log::error('Categoria com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        Log::info('A tentar eliminar a categoria com ID: ' . $id);

        // Verifica se a categoria está associada a produtos
        if ($categoria->produtos()->count() > 0) {
            Log::warning('Não foi possível eliminar a categoria porque existem produtos associados a ela');
            return response()->json([
                'message' => 'Não é possível eliminar a categoria porque existem produtos associados a ela.'
            ], 400);
        }


        if ($categoria->delete()) {
            Log::info('Categoria eliminada com sucesso: ' . $id);

            return response()->json(['message' => 'Categoria eliminada com sucesso']);
        }

        Log::error('Ocorreu um erro ao eliminar a categoria');
        
        return response()->json(['message' => 'Ocorreu um erro ao eliminar a categoria'], 500);
    }
}
