@extends('layout')

@section('title', 'Registo')

@section('content')
<div class="container mt-4">
    <h2>Registo</h2><p>(por defeito como administrador em development)<p>
    <form action="/register" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
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

        <button type="submit" class="btn btn-primary">Registar</button>
    </form>
</div>
@endsection
