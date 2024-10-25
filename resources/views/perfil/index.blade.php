@extends('layout')

@section('title', 'Perfil')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Bem-vindo, {{ Auth::user()->nome }}!</h2>

        <!-- Formulário para atualizar o perfil -->
        <form action="/perfil/actualizar" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ Auth::user()->nome }}" required>
            </div>

            <div class="mb-3">
                <label for="distrito" class="form-label">Distrito</label>
                <input type="text" class="form-control" id="distrito" name="distrito" value="{{ Auth::user()->distrito }}" required>
            </div>

            <div class="mb-3">
                <label for="concelho" class="form-label">Concelho</label>
                <input type="text" class="form-control" id="concelho" name="concelho" value="{{ Auth::user()->concelho }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>

        <!-- Botão para abrir o modal de alteração de password -->
        <button class="btn btn-warning mt-3" onclick="showPasswordModal()">Alterar Password</button>

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

    <!-- Modal para alterar a password -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Alterar Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="/perfil/alterar_password" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="old_password" class="form-label">Password Antiga</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nova Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmar Nova Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Alterar Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabela de Encomendas -->
<h3 class="mt-5">As Minhas Encomendas</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Total</th>
                <th>Data da Encomenda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($encomendas as $encomenda)
                <tr>
                    <td>{{ $encomenda->produto->titulo ?? 'Produto Removido' }}</td>
                    <td>{{ $encomenda->quantidade }}</td>
                    <td>{{ $encomenda->produto ? number_format($encomenda->produto->preco * $encomenda->quantidade, 2) . ' €' : 'N/A' }}</td>
                    <td>{{ $encomenda->criado_em->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Ainda não fez nenhuma encomenda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
    <script src="{{ asset('js/perfil.js') }}"></script>
@endsection
