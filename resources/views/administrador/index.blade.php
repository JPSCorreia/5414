@extends('layout')

@section('title', 'Administrador')

@section('content')
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center">

    <div style="width: 1280px">
        <h3 class="text-center">Gestão de Utilizadores</h3>

        <div class="container mt-4">
            <form action="{{ url('/administrador') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="filter-distrito" class="form-label">Distrito</label>
                    <select name="distrito" id="filter-distrito" class="form-select">
                        <option value="">Todos os Distritos</option>
                        @foreach($distritos as $distrito)
                            <option value="{{ $distrito }}" {{ request('distrito') == $distrito ? 'selected' : '' }}>
                                {{ $distrito }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="filter-concelho" class="form-label">Concelho</label>
                    <select name="concelho" id="filter-concelho" class="form-select">
                        <option value="">Todos os Concelhos</option>
                        @foreach($concelhos as $concelho)
                            <option value="{{ $concelho }}" {{ request('concelho') == $concelho ? 'selected' : '' }}>
                                {{ $concelho }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>

        <!-- Tabela de Utilizadores -->
        <div class="container mt-4">
            <table id="tabela-utilizadores" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Distrito</th>
                        <th>Concelho</th>
                        <th>Admin</th>
                        <th>Ultimo Login</th>
                        <th>Criado Em</th>
                        <th>Actualizado Em</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($utilizadores as $utilizador)
                        <tr id="utilizador-{{ $utilizador->id }}">
                            <td class="utilizador-linha">{{ $utilizador->nome }}</td>
                            <td class="utilizador-linha">{{ $utilizador->email }}</td>
                            <td class="utilizador-linha">{{ $utilizador->distrito }}</td>
                            <td class="utilizador-linha">{{ $utilizador->concelho }}</td>
                            <td class="utilizador-linha">{{ $utilizador->admin ? 'Sim' : 'Não' }}</td>
                            <td class="utilizador-linha">{{ $utilizador->ultimo_login ? $utilizador->ultimo_login->format('d/m/Y, H:i:s') : 'N/A' }}</td>
                            <td class="utilizador-linha">{{ $utilizador->criado_em->format('d/m/Y, H:i:s') }}</td>
                            <td class="utilizador-linha">{{ $utilizador->actualizado_em->format('d/m/Y, H:i:s') }}</td>
                            <td class="utilizador-linha">
                                <div style="display: flex">
                                <!-- Botão para abrir o modal de edição -->
                                <button class="btn btn-sm btn-warning" onclick="showEditUserModal({{ $utilizador->id }})">Editar</button>
                                <!-- Botão para apagar o utilizador -->
                                <button style="margin-left: 8px" class="btn btn-sm btn-danger" onclick="deleteUser({{ $utilizador->id }})">Apagar</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botão para abrir o modal de criação -->
        <div class="container mt-4 text-end">
            <button class="btn btn-success mb-3" onclick="showCreateUserModal()">Novo Utilizador</button>
        </div>

        <!-- Modal para criar novo utilizador -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Criar Novo Utilizador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createUserForm">
                            @csrf
                            <div class="mb-3">
                                <label for="create-nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="create-nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="create-email" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="create-password" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-distrito" class="form-label">Distrito</label>
                                <input type="text" class="form-control" id="create-distrito" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-concelho" class="form-label">Concelho</label>
                                <input type="text" class="form-control" id="create-concelho" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="create-admin">
                                <label class="form-check-label" for="create-admin">Administrador</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Criar Utilizador</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar utilizador -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Editar Utilizador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            @csrf
                            <input type="hidden" id="edit-id">

                            <div class="mb-3">
                                <label for="edit-nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="edit-nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-distrito" class="form-label">Distrito</label>
                                <input type="text" class="form-control" id="edit-distrito" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-concelho" class="form-label">Concelho</label>
                                <input type="text" class="form-control" id="edit-concelho" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="edit-admin">
                                <label class="form-check-label" for="edit-admin">Administrador</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                        </form>

                        <!-- Sucesso -->
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Erros -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="width: 1280px;">

        <h3 class="text-center">Gestão de Produtos</h3>

        <!-- Tabela de Produtos -->
        <div class="container mt-4">
            <table class="table table-striped" id="tabela-produtos">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Imagens</th>
                        <th>Criado Em</th>
                        <th>Actualizado Em</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $produto)
                        <tr id="produto-{{ $produto->id }}">
                            <td class="produto-linha" >{{ $produto->titulo }}</td>
                            <td class="produto-linha" >{{ $produto->descricao }}</td>
                            <td class="produto-linha" >{{ $produto->preco }}€</td>
                            <td class="produto-linha" data-categoria-id="{{ $produto->categoria_id }}">{{ $produto->categoria->nome }}</td>
                            <td class="produto-linha">
                                @if ($produto->imagens->count() > 0)
                                    <img src="{{ asset('images/' . $produto->imagens->last()->URL_imagem) }}" alt="Imagem de {{ $produto->titulo }}" width="50">
                                @else
                                    <span>Sem imagem</span>
                                @endif
                            </td>
                            <td class="produto-linha" >{{ $produto->criado_em->format('d/m/Y, H:i:s') }}</td>
                            <td class="produto-linha" >{{ $produto->actualizado_em->format('d/m/Y, H:i:s') }}</td>
                            <td class="produto-linha" >
                                <div style="display: flex">
                                    <button class="btn btn-sm btn-warning" onclick="showEditProdutoModal({{ $produto->id }})">Editar</button>
                                    <button style="margin-left: 8px" class="btn btn-sm btn-danger" onclick="deleteProduto({{ $produto->id }})">Apagar</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botão para abrir o modal de criação de produto -->
        <div class="container mt-4 text-end">
            <button class="btn btn-success mb-3" onclick="showCreateProdutoModal()">Novo Produto</button>
        </div>

        <!-- Modal para criar novo produto -->
        <div class="modal fade" id="createProdutoModal" tabindex="-1" aria-labelledby="createProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProdutoModalLabel">Criar Novo Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createProdutoForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="create-titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="create-titulo" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="create-descricao" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="create-preco" class="form-label">Preço</label>
                                <input type="number" class="form-control" id="create-preco" required>
                            </div>

                            <div class="mb-3">
                                <label for="create-categoria" class="form-label">Categoria</label>
                                <select id="create-categoria" class="form-select" required>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="create-imagem" class="form-label">Imagem do Produto</label>
                                <input type="file" class="form-control" id="create-imagem" name="imagem" accept="image/*" multiple>
                            </div>

                            <button type="submit" class="btn btn-primary">Criar Produto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar produto -->
<div class="modal fade" id="editProdutoModal" tabindex="-1" aria-labelledby="editProdutoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdutoModalLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProdutoForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit-id">

                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit-titulo" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit-descricao" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-preco" class="form-label">Preço</label>
                        <input type="number" class="form-control" id="edit-preco" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-categoria" class="form-label">Categoria</label>
                        <select id="edit-categoria" class="form-select" required>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mostra a imagem atual (se existir) -->
                    @if ($produto->imagens->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Imagem Atual:</label>
                            <img src="{{ asset('images/' . $produto->imagens->last()->URL_imagem) }}" alt="Imagem do produto" width="100">
                        </div>
                    @endif

                    <!-- Campo para alterar a imagem -->
                    <div class="mb-3">
                        <label for="edit-imagem" class="form-label">Nova Imagem do Produto (opcional)</label>
                        <input type="file" class="form-control" id="edit-imagem" name="imagem" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                </form>
            </div>
        </div>
    </div>

</div>

    </div>
            <!-- Gestão de Categorias -->
            <div style="width: 720px">
                <h3 class="text-center mt-5">Gestão de Categorias</h3>
                <div class="container mt-4">
                    <table class="table table-striped" id="tabela-categorias">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Criado Em</th>
                                <th>Actualizado Em</th>
                                <th>Acções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                                <tr id="categoria-{{ $categoria->id }}">
                                    <td class="categoria-linha" style="width: 180px">{{ $categoria->nome }}</td>
                                    <td class="categoria-linha" style="width: 180px">{{ $categoria->criado_em->format('d/m/Y, H:i:s') }}</td>
                                    <td class="categoria-linha" style="width: 180px">{{ $categoria->actualizado_em->format('d/m/Y, H:i:s') }}</td>
                                    <td class="categoria-linha" style="width: 120px">
                                        <div style="display: flex">
                                            <!-- Botão para abrir o modal de edição -->
                                            <button class="btn btn-sm btn-warning" onclick="showEditCategoryModal({{ $categoria->id }})">Editar</button>
                                            <!-- Botão para apagar a categoria -->
                                            <button style="margin-left: 8px" class="btn btn-sm btn-danger" onclick="deleteCategory({{ $categoria->id }})">Apagar</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            <!-- Botão para abrir o modal de criação -->
            <div class="container mt-4 text-end">
                <button class="btn btn-success mb-3" onclick="showCreateCategoryModal()">Nova Categoria</button>
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
                                    <label for="create-category-name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="create-category-name" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Criar Categoria</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para editar categoria -->
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
                                    <label for="edit-category-name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="edit-category-name" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div style="width: 1280px;">
        <h3 class="text-center">Listagem de Encomendas</h3>

        <!-- Tabela de Encomendas -->
        <div class="container mt-4">
            <table class="table table-striped" id="tabela-encomendas">
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Criado Em</th>
                        <th>Actualizado Em</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($encomendas as $encomenda)
                        <tr id="encomenda-{{ $encomenda->id }}">
                            <td class="encomenda-linha">{{ $encomenda->utilizador->nome }}</td>
                            <td class="encomenda-linha">{{ $encomenda->produto->titulo }}</td>
                            <td class="encomenda-linha">{{ $encomenda->quantidade }}</td>
                            <td class="encomenda-linha">{{ $encomenda->criado_em->format('d/m/Y, H:i:s') }}</td>
                            <td class="encomenda-linha">{{ $encomenda->actualizado_em->format('d/m/Y, H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
    <script src="{{ asset('js/administrador.js') }}"></script>
@endsection
