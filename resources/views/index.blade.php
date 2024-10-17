@extends('layout')

@section('title', 'Página Principal')

@section('content')
    <h1 class="text-center">Bem-vindo à nossa Loja</h1>

    <!-- Secção de categorias -->
    <h2>Categorias</h2>
<div class="row">
    @foreach($categorias as $categoria)
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $categoria->nome }}</h5>
                    <a href="/categorias/{{ $categoria->id }}" class="btn btn-primary">Ver Produtos</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
