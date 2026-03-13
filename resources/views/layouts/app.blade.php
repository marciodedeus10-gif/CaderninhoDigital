<!DOCTYPE html>
<html>

<head>
    <title>Caderninho Digital</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/topbar.css') }}" rel="stylesheet">
    <style>
        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu>li {
            position: relative;
            display: inline-block;
        }

        .menu a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #2c3e50;
            color: white;
        }

        .menu a:hover {
            background-color: #34495e;
        }

        /* Submenu */
        .submenu {
            display: none;
            position: absolute;
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: 150px;
        }

        .submenu li a {
            background-color: #34495e;
        }

        /* MOSTRA AO PASSAR O MOUSE */
        .dropdown:hover .submenu {
            display: block;
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

        <div class="container-fluid">
            <div class="row">

                <!-- MENU LATERAL -->
                <div class="col-md-2 bg-dark text-white min-vh-100 p-3">

                    <h4 class="text-center">Caderninho Digital</h4>
                    <hr>

                    <ul class="nav flex-column">

                        <li class="nav-item mb-2">
                            <a href="/dashboard" class="nav-link text-white">
                                🏠 Dashboard
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="/clientes" class="nav-link text-white">
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
