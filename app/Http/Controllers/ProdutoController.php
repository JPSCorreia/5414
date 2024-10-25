<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ImagensProduto;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    // Listar todos os produtos
    public function index()
    {
        Log::info('A tentar encontrar todos os produtos');

        $produtos = Produto::with('categoria', 'imagens')->get
        (); // Inclui a categoria e imagens relacionadas, usar all em vez de with se quisermos apenas os dados dos produtos.

        $categorias = Categoria::all();

        Log::info('Produtos encontrados com sucesso.');

        if (request()->wantsJson()) {
            Log::info('A tentar retornar os produtos como JSON');
            return response()->json($produtos);
        }

        Log::info('A tentar devolver os produtos');
        return view('produtos.index', compact('produtos', 'categorias'));
    }

    // Mostrar um produto específico
    public function show($id)
    {
        Log::info('A tentar encontrar o produto: ' . $id);

        $produto = Produto::with('categoria', 'imagens')->find($id); // Inclui a categoria e imagens

        if (!$produto) {
            Log::error('Produto com ID ' . $id . ' não encontrado');
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        Log::info('Produto encontrado: ' . $id);
        return response()->json($produto);
    }

    // Criar novo produto
    public function store(Request $request)
    {
        Log::info('A tentar criar um novo produto, a validar dados enviados no request: ', $request->all());

        // Validação dos dados
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        Log::info('Dados validados com sucesso, a tentar criar novo produto...');

        // Criar o produto
        $produto = Produto::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
        ]);

        Log::info('Produto criado, a tentar adicionar imagens ao novo produto...');

        // Processar e guardar as imagens
        if ($request->hasFile('imagem')) {
            $nomeImagem = time() . '_' . $request->file('imagem')->getClientOriginalName();
            $request->file('imagem')->move(public_path('images'), $nomeImagem);
            ImagensProduto::create([
                'produto_id' => $produto->id,
                'URL_imagem' => $nomeImagem
            ]);
        }

        // Retornar uma resposta JSON
        return response()->json(['success' => true, 'produto' => $produto], 201);

    }

    public function update(Request $request, $id)
    {
        Log::info('A tentar atualizar o produto com ID: ' . $id);

        $produto = Produto::find($id);

        if (!$produto) {
            Log::error('Produto com ID ' . $id . ' não encontrado');
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        Log::info('A tentar validar dados enviados no request...');

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        Log::info('Dados validados com sucesso, a tentar atualizar...');

        $produto->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
        ]);

        // Verifica se uma nova imagem foi carregada e adiciona ao produto
        if ($request->hasFile('imagem')) {
            $nomeImagem = time() . '_' . $request->file('imagem')->getClientOriginalName();
            $request->file('imagem')->move(public_path('images'), $nomeImagem);

            ImagensProduto::create([
                'produto_id' => $produto->id,
                'URL_imagem' => $nomeImagem
            ]);
        }

        Log::info('Produto atualizado com sucesso: ' . $id);

        return response()->json(['success' => true, 'produto' => $produto], 200);
    }

    // Eliminar produto existente
    public function destroy($id)
    {
        Log::info('A tentar procurar para o produto com ID: ' . $id);

        $produto = Produto::find($id);

        if (!$produto) {
            Log::error('Produto com ID ' . $id . ' não encontrado');

            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        Log::info('A tentar eliminar o produto com ID: ' . $id);

        // Apagar as imagens associadas
        foreach ($produto->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->URL_imagem);
            $imagem->delete();
        }

        if ($produto->delete()) {
            Log::info('Produto eliminado com sucesso: ' . $id);

            return response()->json(['success' => true, 'message' => 'Produto apagado com sucesso.'], 200);
        }

        $produto->delete();

        Log::error('Ocorreu um erro ao eliminar o produto');

        return response()->json(['message' => 'Ocorreu um erro ao eliminar o produto'], 500);

    }
}
