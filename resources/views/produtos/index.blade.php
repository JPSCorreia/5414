@extends('layout')
@section('title', 'Produtos')
@section('content')
    <h1 class="text-center">Produtos Disponíveis</h1>
    <h2>Produtos</h2>
    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->titulo }}</h5>
                        <p class="card-text">{{ $produto->descricao }}</p>
                        <img src="{{ asset('storage/' . $produto->imagens->first()->URL_imagem) }}" 
                            class="card-img-top" 
                            alt="{{ $produto->titulo }} imagem placeholder" 
                            width="100" 
                            height="100">
                        
                        <p class="card-text"><strong>Preço: </strong>{{ $produto->preco }}€</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection