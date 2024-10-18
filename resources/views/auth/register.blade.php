@extends('layout')

@section('title', 'Registo')

@section('content')
<div class="container mt-4">
    <h2>Registo</h2>
    <form action="/register" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="distrito" class="form-label">Distrito</label>
            <input type="text" class="form-control" id="distrito" name="distrito" required>
        </div>

        <div class="mb-3">
            <label for="concelho" class="form-label">Concelho</label>
            <input type="text" class="form-control" id="concelho" name="concelho" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmação da Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1">
            <label class="form-check-label" for="admin">Criar como administrador (só para development)</label>
        </div>

        <button type="submit" class="btn btn-primary">Registar</button>
    </form>
</div>
@endsection
