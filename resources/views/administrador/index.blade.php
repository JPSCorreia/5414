@extends('layout')

@section('title', 'Página de Administrador')

@section('content')
    <h3 class="text-center">Gestão de Utilizadores</h3>

    <div class="container mt-4">
        <table class="table table-striped">
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
                </tr>
            </thead>
            <tbody>
                @foreach($utilizadores as $utilizador)
                    <tr id="utilizador-{{ $utilizador->id }}">
                        <td>{{ $utilizador->nome }}</td>
                        <td>{{ $utilizador->email }}</td>
                        <td>{{ $utilizador->distrito }}</td>
                        <td>{{ $utilizador->concelho }}</td>
                        <td>{{ $utilizador->admin ? 'Sim' : 'Não' }}</td>
                        <td>{{ $utilizador->ultimo_login ? $utilizador->ultimo_login->format('d/m/Y, H:i:s') : 'N/A' }}</td>
                        <td>{{ $utilizador->criado_em->format('d/m/Y, H:i:s') }}</td>
                        <td>{{ $utilizador->actualizado_em->format('d/m/Y, H:i:s') }}</td>
                        <td>
                            <!-- Botão para abrir o modal de edição -->
                            <button class="btn btn-sm btn-warning" onclick="showEditModal({{ $utilizador->id }})">Editar</button>
                        </td>
                        <td>
                            <!-- Botão para apagar o utilizador -->
                            <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $utilizador->id }})">Apagar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Botão para abrir o modal de criação -->
    <div class="container mt-4 text-end">
        <button class="btn btn-success mb-3" onclick="showCreateModal()">Novo Utilizador</button>
    </div>

    <!-- Modal para criar novo utilizador -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Criar Novo Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Utilizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
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

    <script src="{{ asset('js/administrador.js') }}"></script>
@endsection
