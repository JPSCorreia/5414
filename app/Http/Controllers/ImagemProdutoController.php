<?php

namespace App\Http\Controllers;

use App\Models\ImagemProduto;
use Illuminate\Http\Request;

class ImagemProdutoController extends Controller
{
    // Listar todas as imagens de um produto
    public function index($produto_id)
    {
        $imagens = ImagemProduto::where('produto_id', $produto_id)->get();
        return response()->json($imagens);
    }

    // Adicionar nova imagem a um produto
    public function store(Request $request, $produto_id)
    {
        $request->validate([
            'URL_imagem' => 'required|string|max:255',
        ]);

        $imagem = ImagemProduto::create([
            'produto_id' => $produto_id,
            'URL_imagem' => $request->URL_imagem,
        ]);

        return response()->json($imagem, 201); // Imagem criada
    }

    // Eliminar uma imagem de um produto
    public function destroy($id)
    {
        $imagem = ImagemProduto::find($id);

        if (!$imagem) {
            return response()->json(['message' => 'Imagem não encontrada'], 404);
        }

        $imagem->delete();

        return response()->json(['message' => 'Imagem eliminada com sucesso']);
    }
}
