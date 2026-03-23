<!DOCTYPE html>
<html>

<head>
    <title>Login - Caderninho Digital</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .logo {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="login-box">
            <h3 class="text-center logo mb-4">Criar Conta</h3>

            <form>
                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" class="form-control">
                </div>

                <button class="btn btn-success w-100 mb-3">Cadastrar</button>
            </form>

            <div class="text-center">
                <small>Já tem conta?</small><br>
                <a href="/login" class="btn btn-outline-secondary mt-2 w-100">
                    Voltar para Login
                </a>
            </div>
        </div>
    </div>


</body>

</html>
