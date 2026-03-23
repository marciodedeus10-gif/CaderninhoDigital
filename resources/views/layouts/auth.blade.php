<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #4888ff, #5c98ff);
        }

        .auth-container {
            height: 100vh;
        }

        .card {
            border-radius: 12px;
        }

        .project-title {
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center auth-container">

    <div style="width: 100%; max-width: 400px;">

        <!-- TÍTULO DO PROJETO -->
        <h3 class="project-title">📒 Caderninho Digital</h3>

        <div class="card shadow p-4">

            @yield('content')

        </div>
    </div>

</div>

</body>

</html>
