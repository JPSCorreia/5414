@extends('layout')

@section('title', 'Página Principal')

@section('content')
    <h1 class="text-center">Bem-vindo à nossa Loja</h1>

    <!-- Secção de categorias -->
    <h2>Categorias</h2>

    <!-- Botão para abrir o modal de criação de nova categoria -->
    <div class="mb-4 text-end">
        <button class="btn btn-success" onclick="showCreateCategoryModal()">Nova Categoria</button>
    </div>

    <div class="row">
        @foreach($categorias as $categoria)
            <div class="col-md-3" id="categoria-{{ $categoria->id }}">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $categoria->nome }}</h5>
                        <a href="/categorias/{{ $categoria->id }}" class="btn btn-primary">Ver Produtos</a>
                        <!-- Botões de editar e eliminar -->
                        <button class="btn btn-sm btn-warning mt-2" onclick="showEditCategoryModal({{ $categoria->id }}, '{{ $categoria->nome }}')">Editar</button>
                        <button class="btn btn-sm btn-danger mt-2" onclick="deleteCategory({{ $categoria->id }})">Eliminar</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal para criar nova categoria -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Criar Nova Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="create-nome" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="create-nome" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Criar Categoria</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar categoria existente -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        @csrf
                        <input type="hidden" id="edit-category-id">
                        <div class="mb-3">
                            <label for="edit-nome" class="form-label">Nome da Categoria</label>
                            <input type="text" class="form-control" id="edit-nome" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/categorias.js') }}"></script>
@endsection
