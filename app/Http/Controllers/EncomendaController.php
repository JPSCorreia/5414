<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encomenda;
use App\Models\Produto;
use App\Models\EncomendaProduto;


class EncomendaController extends Controller
{
    public function index()
    {
        $encomendas = Encomenda::with('Utilizador')->get(); // Obtém todas as encomendas
        return view('administrador.index_encomenda', compact('encomendas')); // Supondo que esta seja a view para listar encomendas
    }

    // Função para editar uma encomenda específica
    public function edit($id)
    {
        $encomenda = Encomenda::with('Utilizador')->findOrFail($id); // Procura a encomenda pelo ID
        $produtos = Produto::all(); // Carrega todos os produtos disponíveis

        return view('administrador.edit_encomenda', compact('encomenda', 'produtos'));
    }

    /**
     * Atualiza uma encomenda existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $encomendaProduto = EncomendaProduto::findOrFail($id);
    
    // Aqui, deves validar os dados do request antes de atualizar a encomenda_produto.
    $request->validate([
        'produto_id' => 'required|exists:produtos,id',
        'quantidade' => 'required|integer|min:1',
    ]);

    // Atualiza os dados da encomenda_produto conforme necessário
    $encomendaProduto->produto_id = $request->input('produto_id');
    $encomendaProduto->quantidade = $request->input('quantidade');
    $encomendaProduto->save(); // Salva as alterações

    return redirect()->route('administrador.encomendas.index')->with('success', 'Produto da encomenda atualizado com sucesso');
}
}
