@extends('layout')

@section('title', 'Perfil')

@section('content')
    <div class="container mt-4">
        <h2>Bem-vindo, {{ Auth::user()->nome }}!</h2>
        <ul>
            <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
            <li><strong>Distrito:</strong> {{ Auth::user()->distrito }}</li>
            <li><strong>Concelho:</strong> {{ Auth::user()->concelho }}</li>
        </ul>
    </div>
@endsection
