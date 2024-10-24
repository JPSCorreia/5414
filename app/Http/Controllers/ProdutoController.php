<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Categoria;

use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    // Listar todos os produtos
    public function index()
    {
        Log::info('A tentar encontrar todos os produtos');

        $produtos = Produto::with('categoria', 'imagens')->get
        (); // Inclui a categoria e imagens relacionadas, usar all em vez de with se quisermos apenas os dados dos produtos.
        
        Log::info('Produtos encontrados com sucesso.'); 
        
        if (request()->wantsJson()) {
            Log::info('A tentar retornar os produtos como JSON');
            return response()->json($produtos);
        }

        Log::info('A tentar retornar os produtos como HTML');
        return view('produtos/index', ['produtos' => $produtos]);
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
    
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id', // Verifica que a categoria existe
            'imagem' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Adiciona a validação da imagem
        ]);
    
        Log::info('Dados validados com sucesso, a tentar criar novo produto...');
    
        $produto = Produto::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
        ]);
    
        // Verifica se existe uma imagem
        if ($request->hasFile('imagem')) {
            // Guarda a imagem no disco público
            $imagemPath = $request->file('imagem')->store('imagens_produtos', 'public');
            
            // Cria a entrada na tabela imagens_produto
            $produto->imagens()->create([
                'URL_imagem' => $imagemPath,
            ]);
        }
    
        Log::info('Produto criado com sucesso: ' . $request->titulo);
    
        return response()->json($produto, 201);
    }
    
    public function update(Request $request, $id)
    {
        Log::info('A tentar atualizar o produto com ID: ' . $id);
    
        $produto = Produto::find($id);
    
        if (!$produto) {
            Log::error('Produto com ID ' . $id . ' não encontrado');
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
    
        Log::info('A tentar validar dados enviados no request: ', $request->all());
    
        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|string',
            'preco' => 'sometimes|numeric',
            'categoria_id' => 'sometimes|exists:categorias,id',
            'imagem' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Adiciona a validação da imagem
        ]);
    
        Log::info('Dados validados com sucesso, a tentar atualizar...');
    
        $produto->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'categoria_id' => $request->categoria_id,
        ]);
    
        // Verifica se existe uma nova imagem
        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga, se existir
            $produto->imagens()->each(function ($imagem) {
                Storage::disk('public')->delete($imagem->URL_imagem);
                $imagem->delete(); // Apaga a entrada na tabela imagens_produto
            });
    
            // Guarda a nova imagem
            $imagemPath = $request->file('imagem')->store('imagens_produtos', 'public');
    
            // Cria a nova entrada na tabela imagens_produto
            $produto->imagens()->create([
                'URL_imagem' => $imagemPath,
            ]);
        }
    
        Log::info('Produto atualizado com sucesso: ' . $id);
    
        return response()->json($produto);
    }

    public function create()
    {
        $categorias = Categoria::all(); // Assume que já tens um modelo Categoria
        return view('produtos.create', compact('categorias'));
    }

    public function edit($id)
    {
        $produto = Produto::find($id);
        $categorias = Categoria::all(); // Assume que já tens um modelo Categoria
        return view('produtos.edit', compact('produto', 'categorias'));
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

        // Verifica se o produto tem imagens associadas
        if ($produto->imagens()->count() > 0) {
            Log::warning('Não foi eliminado o produto porque existem imagens associadas a ele');
            return response()->json([
                'message' => 'Não foi possível eliminar o produto porque existem imagens associadas a ele.'
            ], 400);
        }

        if ($produto->delete()) {
            Log::info('Produto eliminado com sucesso: ' . $id);

            return response()->json(['message' => 'Produto eliminado com sucesso'], 200);
        }

        Log::error('Ocorreu um erro ao eliminar o produto');

        return response()->json(['message' => 'Ocorreu um erro ao eliminar o produto'], 500);

    }
}
