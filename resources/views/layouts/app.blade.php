<!DOCTYPE html>
<html>

<head>
    <title>Caderninho Digital</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/topbar.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 70px;
            background: linear-gradient(90deg, #0d6efd, #0b5ed7);
        }

        /* BUSCA */
        .search {
            width: 200px;
            border-radius: 20px;
            border: none;
            padding: 5px 15px;

        }

        /* FOTO */
        .user-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        /* NOTIFICAÇÃO */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 10px;
        }

        body.bg-dark {
            background-color: #121212 !important;
            color: #fff;
        }
    </style>

</head>

<body>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Caderninho Digital</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    </head>

    <body>
    <body class="{{ auth()->check() && auth()->user()->tema == 'escuro' ? 'bg-dark text-white' : '' }}">
        {{-- CONTEÚDO --}}
        <div class="content w-100">

            {{-- TOPBAR AZUL --}}
            <div class="topbar d-flex justify-content-between align-items-center px-4">

                {{-- ESQUERDA --}}
                <h5 class="text-white mb-0">Dashboard</h5>

                {{-- DIREITA --}}
                <div class="d-flex align-items-center gap-3">

                    {{-- BUSCA --}}
                    <input type="text" class="form-control search" placeholder="Buscar...">

                    {{-- NOTIFICAÇÃO --}}
                    <i class="bi bi-bell text-white fs-5 position-relative">
                        <span class="badge bg-danger notification-badge">3</span>
                    </i>

                    {{-- CONFIG --}}
                    <a href="{{ route('perfil.edit') }}">
                        <i class="bi bi-gear text-white"></i>
                    </a>
                    {{-- FOTO --}}
                    <img src="https://i.pravatar.cc/40" class="rounded-circle user-img">

                </div>
            </div>

            <div class="container-fluid">
                <div class="row">

                    <!-- MENU LATERAL -->
                    <div class="col-md-2 text-white min-vh-100 p-3" style="background-color: #1E3A8A;">

                        <h4 class="text-center">Caderninho Digital</h4>
                        <hr>

                        <ul class="nav flex-column">

                            <li class="nav-item mb-2">
                                <a href="/dashboard" class="nav-link text-white">
                                    🏠 Dashboard
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('quemSomos.index') }}" class="nav-link text-white">
                                    📖 Quem Somos
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('contatos.index') }}" class="nav-link text-white">
                                    📩 Contatos
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="{{ route('clientes.index') }}" class="nav-link text-white">
                                    👥 Clientes
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="/vendas" class="nav-link text-white">
                                    💰 Vendas
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="/produtos" class="nav-link text-white">
                                    📦 Produtos
                                </a>
                            </li>

                            <li class="nav-item mb-2">
                                <a href="/servicos" class="nav-link text-white">
                                    🛠 Serviços
                                </a>
                            </li>

                        </ul>

                    </div>

                    <!-- CONTEÚDO -->
                    <div class="col-md-10 p-4">

                        @yield('content')

                    </div>

                </div>
            </div>

    </body>

    </html>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
