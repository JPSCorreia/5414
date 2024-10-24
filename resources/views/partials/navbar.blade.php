<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Loja</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/produtos">Produtos</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <!-- Mostrar apenas para utilizadores autenticados -->
                @auth
                    @if(Auth::user()->admin)
                        <li class="nav-item">
                            <a class="nav-link" href="/administrador">Administrador</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('administrador.encomendas.index') }}">Encomendas</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/perfil">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- Mostrar para visitantes -->
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Registo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
