<?php

namespace App\Http\Controllers;

use App\Models\Imagem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ImagemController extends Controller
{
    // Listar todas as imagens de um produto
    public function index($produto_id)
    {
        Log::info('A tentar encontrar todas as imagens do produto: ' . $produto_id);

        $imagens = Imagem::where('produto_id', $produto_id)->get();

        Log::info('Imagens encontradas do produto: ' . $produto_id);

        return response()->json($imagens);
    }

    // Mostrar uma imagem de um produto
    public function show($id)
    {
        Log::info('A tentar encontrar a imagem: ' . $id);

        $imagem = Imagem::find($id);

        if (!$imagem) {
            Log::error('Imagem com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        Log::info('Imagem encontrada: ' . $id);

        return response()->json($imagem);
    }

    // Adicionar nova imagem a um produto
    public function store(Request $request, $produto_id)
    {
        Log::info('A tentar criar uma nova imagem, a validar dados enviados no request: ', $request->all());

        $request->validate([
            'URL_imagem' => 'required|string|max:255',
        ]);

        Log::info('Dados validados com sucesso, a tentar criar nova imagem...');

        $imagem = Imagem::create([
            'produto_id' => $produto_id,
            'URL_imagem' => $request->URL_imagem,
        ]);

        Log::info('Imagem criada com sucesso: ' . $request->URL_imagem);

        return response()->json($imagem, 201);
    }

    // Atualizar uma imagem de um produto
    public function update(Request $request, $id)
    {
        Log::info('A tentar atualizar a imagem com ID: ' . $id);

        $imagem = Imagem::find($id);

        if (!$imagem) {
            Log::error('Imagem com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        Log::info('A tentar validar dados enviados no request: ', $request->all());

        $request->validate([
            'URL_imagem' => 'required|string|max:255',
        ]);

        Log::info('Dados validados com sucesso, a tentar atualizar...');

        $imagem->update([
            'URL_imagem' => $request->URL_imagem,
        ]);

        Log::info('Imagem atualizada com sucesso: ' . $request->URL_imagem);

        return response()->json($imagem);
    }

    // Eliminar uma imagem de um produto
    public function destroy($id)
    {
        Log::info('A tentar encontrar e eliminar a imagem com ID: ' . $id);

        $imagem = Imagem::find($id);

        if (!$imagem) {
            Log::error('Imagem com ID ' . $id . ' não encontrada');
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        Log::info('A tentar eliminar a imagem com ID: ' . $id);

        if($imagem->delete()) {
            Log::info('Imagem eliminada com sucesso: ' . $id);

            return response()->json(['message' => 'Imagem eliminada com sucesso']);
        }

        Log::error('Ocorreu um erro ao eliminar a imagem');

        return response()->json(['message' => 'Ocorreu um erro ao eliminar a imagem'], 500);
    }
}
