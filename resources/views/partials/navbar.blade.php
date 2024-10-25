<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Megastore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/categorias">Categorias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/produtos">Produtos</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">


                <!-- Mostrar apenas para admins -->
                @auth
                    <!-- Carrinho de Compras -->
                    <li class="nav-item" style=" margin-right: 10px;">
                        <a class="nav-link position-relative" href="/carrinho"> <!--TODO: acabar o carrinho -->
                            <i class="bi bi-cart"></i> <!-- Ícone de carrinho de compras -->
                            <span class="position-absolute top-40 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem; width: 18px; height: 18px; padding: 0; line-height: 18px;">
                                {{ $totalItensCarrinho ?? 0 }} <!-- Número de produtos no carrinho -->
                            </span>
                        </a>
                    </li>

                    @if(Auth::user()->admin)
                        <li class="nav-item">
                            <a class="nav-link" href="/administrador">Administrador</a>
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
