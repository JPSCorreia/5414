@extends('layout')

@section('title', 'Lista de Utilizadores')

@section('content')
    <h1 class="text-center">Lista de Utilizadores</h1>

    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Distrito</th>
                    <th>Concelho</th>
                    <th>Admin</th>
                    <th>Último Login</th>
                    <th>Criado Em</th>
                    <th>Atualizado Em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($utilizadores as $utilizador)
                    <tr>
                        <td>{{ $utilizador->id }}</td>
                        <td>{{ $utilizador->nome }}</td>
                        <td>{{ $utilizador->email }}</td>
                        <td>{{ $utilizador->distrito }}</td>
                        <td>{{ $utilizador->concelho }}</td>
                        <td>{{ $utilizador->admin ? 'Sim' : 'Não' }}</td>
                        <td>{{ $utilizador->ultimo_login ?? 'N/A' }}</td>
                        <td>{{ $utilizador->criado_em }}</td>
                        <td>{{ $utilizador->actualizado_em }}</td>
                        <td>
                            <!-- Link para editar ou ver detalhes do utilizador -->
                            <a href="/utilizadores/{{ $utilizador->id }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="/utilizadores/{{ $utilizador->id }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
