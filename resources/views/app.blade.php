<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel de Administração')</title>

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef3ff, #e3eafc);
            font-family: "Inter", system-ui, sans-serif;
            min-height: 100vh;
        }

        /* Navbar fixa no topo */
        .navbar {
            background-color: #474747;
            padding: 0.8rem 1.5rem;
        }

        /* 🔹 Menu mais à direita — alinhado com a tabela */
        .navbar-nav {
            margin-left: 8rem;
        }

        .navbar-nav .nav-link {
            color: #ffffff;
            margin-right: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #4a68ff;
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link[aria-current="page"] {
            color: #000000 !important;
            font-weight: 600;
        }

        /* Container do conteúdo principal */
        .content-wrapper {
            padding: 2rem;
            margin-top: 80px;
        }

        footer {
            text-align: center;
            padding: 1rem;
            margin-top: 3rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .navbar-nav {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- 🔝 Menu principal -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">

            <!-- Botão mobile -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu alinhado -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('noticias.*') ? 'active' : '' }}" href="{{ route('noticias.index') }}">
                            <i class="bi bi-megaphone me-1"></i> Notícias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
                            <i class="bi bi-folder2-open me-1"></i> Categorias
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="content-wrapper container">
        @yield('content')
    </div>

    <!-- Rodapé -->
    <footer>
        <p>© {{ date('Y') }} Painel de Administração</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
