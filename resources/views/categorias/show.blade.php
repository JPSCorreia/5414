@extends('layout')

@section('title', 'Categoria: ' . $categoria->nome)

@section('content')
    <h1>Categoria: {{ $categoria->nome }}</h1>

    <div class="container mt-4">
        <!-- Lista de produtos da categoria -->
        <h2>{{ $categoria->produtos->count() }}  {{ $categoria->produtos->count() == 1 ? 'Produto disponível nesta categoria' : 'Produtos disponíveis nesta categoria'}}</h2>
        <div class="row">
            @foreach($categoria->produtos as $produto)
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produto->titulo }}</h5>
                            <p class="card-text">{{ $produto->descricao }}</p>
                            <img src="{{ $produto->imagens->first()->URL_imagem ?? 'default-image.jpg' }}" class="card-img-top" alt="{{ $produto->titulo }} placeholder image">
                            <p class="card-text"><strong>Preço: </strong>{{ $produto->preco }}€</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
