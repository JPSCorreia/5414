@extends('layout')

@section('content')
<div class="container">
    <h1>Editar Encomenda #{{ $encomenda->id }}</h1>

    <form action="{{ route('administrador.encomendas.update', $encomenda->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <h2>Editar Encomenda: {{ $encomenda->id }}</h2>

        
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select id="produto_id" name="produto_id" class="form-control">
                @foreach($produtos as $produto) 
                    <option value="{{ $produto->id }}" {{ $produto->id == $encomenda->produto_id ? 'selected' : '' }}>
                        {{ $produto->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ old('quantidade', $encomenda->quantidade) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
    </form>
</div>
@endsection
