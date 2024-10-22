@extends('layout')


@section('title', 'Montra de Loja')

@section('content')
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montra de Loja</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">
    <h1>Bem vindo a nossa loja </h1>
    
    <!-- Carousel -->
    <div id="montraCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($categories as $index => $categoria)
                @php
                    // Obtém o primeiro produto da categoria
                    $produto = $categoria->produtos->first();
                @endphp
                
                @if($produto)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $produto->titulo }}</h5>
                                        <p class="card-text"><strong>Categoria:</strong> {{ $categoria->nome }}</p>
                                        <p class="card-text">{{ $produto->descricao }}</p>
                                        <img src="{{ asset('storage/' . $produto->imagens->first()->URL_imagem) }}" 
                                            class="card-img-top" 
                                            alt="{{ $produto->titulo }} imagem placeholder" 
                                            width="200" 
                                            height="200">
                                        <p class="card-text"><strong>Preço: </strong>{{ number_format($produto->preco, 2, ',', '.') }}€</p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#montraCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#montraCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
    </div>
</div>



<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
@endsection
