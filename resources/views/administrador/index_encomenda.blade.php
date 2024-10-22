@extends('layout')

@section('content')
<div class="container">
    <h1>Encomendas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilizador</th>
                <th>Data da Encomenda</th>
                <th>Produtos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($encomendas as $encomenda)
                <tr>
                    <td>{{ $encomenda->id }}</td>
                    <td>{{ $encomenda->utilizador->nome }}</td>
                    <td>{{ $encomenda->data_encomenda }}</td>
                    <td>
                        <ul>
                            @foreach($encomenda->produtos as $produto)
                                <li>{{ $produto->titulo }} ({{ $produto->pivot->quantidade }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('administrador.encomendas.edit', $encomenda->id) }}" class="btn btn-primary">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
