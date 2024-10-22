@extends('layout')

@section('content')
    <h1>Criar Produto</h1>

    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="categoria_id">Categoria:</label>
            <select id="categoria_id" name="categoria_id" class="form-control" required>
                <!-- Aqui deves gerar as opções das categorias, exemplo -->
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Criar Produto</button>
    </form>
@endsection
