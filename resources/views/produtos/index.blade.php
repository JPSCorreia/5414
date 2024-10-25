@extends('layout')
@section('title', 'Produtos')
@section('content')
    <h1 class="text-center mb-4">Produtos Disponíveis</h1>
    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-3">
                <div class="card mb-4" style="min-height: 400px; height: 450px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $produto->titulo }}</h5>
                        <p class="card-text">{{ $produto->descricao }}</p>
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ asset('images/' . $produto->imagens->first()->URL_imagem) }}"
                                class="card-img-top"
                                alt="{{ $produto->titulo }} imagem placeholder"
                                style="width: 200px; height: 200px; object-fit: contain;"
                            >
                        </div>
                        <div class="mt-auto">
                            <p class="card-text"><strong>Preço: </strong>{{ $produto->preco }}€</p>
                            <button class="btn btn-primary mt-2 add-to-cart" data-id="{{ $produto->id }}">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/produtos.js') }}"></script>
@endsection
