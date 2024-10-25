@extends('layout')

@section('title', 'Carrinho de Compras')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Carrinho de Compras</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($carrinho))
        <p>O seu carrinho está vazio.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrinho as $item)
                    <tr>
                        <td>{{ $item['nome'] }}</td>
                        <td>{{ $item['preco'] }}€</td>
                        <td>
                            <form action="/carrinho/actualizar" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $item['produto_id'] }}">
                                <input type="number" name="quantidade" value="{{ $item['quantidade'] }}" min="1" class="form-control d-inline" style="width: 80px;">
                                <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                            </form>
                        </td>
                        <td>{{ $item['preco'] * $item['quantidade'] }}€</td>
                        <td>
                            <form action="/carrinho/remover" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $item['produto_id'] }}">
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>{{ $total }}€</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <form action="/carrinho/encomendar" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Realizar Encomenda</button>
        </form>
    @endif
</div>
@endsection
