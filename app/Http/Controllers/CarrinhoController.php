<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Encomenda;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    // Visualizar o carrinho
    public function index()
    {
        $carrinho = session()->get('carrinho', []);
        $total = array_reduce($carrinho, function ($total, $item) {
            return $total + $item['preco'] * $item['quantidade'];
        }, 0);

        return view('carrinho.index', compact('carrinho', 'total'));
    }

    public function adicionar(Request $request)
    {
        $produto = Produto::find($request->produto_id);

        if (!$produto) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produto->id])) {
            $carrinho[$produto->id]['quantidade'] += $request->quantidade;
        } else {
            $carrinho[$produto->id] = [
                'produto_id' => $produto->id,
                'nome' => $produto->titulo,
                'preco' => $produto->preco,
                'quantidade' => $request->quantidade
            ];
        }

        session()->put('carrinho', $carrinho);

        // Calcular o total de itens no carrinho
        $totalItensCarrinho = array_sum(array_column($carrinho, 'quantidade'));

        return response()->json(['success' => true, 'totalItensCarrinho' => $totalItensCarrinho]);
    }


    // Atualizar a quantidade de um produto no carrinho
    public function actualizar(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$request->produto_id])) {
            $carrinho[$request->produto_id]['quantidade'] = $request->quantidade;
            session()->put('carrinho', $carrinho);
        }

        return redirect('/carrinho')->with('success', 'Quantidade atualizada.');
    }

    // Remover um produto do carrinho
    public function remover(Request $request)
    {
        $carrinho = session()->get('carrinho', []);
        unset($carrinho[$request->produto_id]);
        session()->put('carrinho', $carrinho);

        return redirect('/carrinho')->with('success', 'Produto removido do carrinho.');
    }

    // Realizar a encomenda com os produtos no carrinho
    public function encomendar()
    {
        $carrinho = session()->get('carrinho', []);

        foreach ($carrinho as $item) {
            Encomenda::create([
                'utilizador_id' => Auth::id(),
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
            ]);
        }

        session()->forget('carrinho');

        return redirect('/carrinho')->with('success', 'Encomenda realizada com sucesso!');
    }
}
