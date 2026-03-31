<!DOCTYPE html>
<html>

<head>
    <title>Recuperar Senha - Caderninho Digital</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 380px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-custom {
            border-radius: 12px;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-custom:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .logo {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">

        <div class="login-box text-center">

            <h3 class="logo mb-3">Caderninho Digital</h3>
            <p class="text-muted mb-4">Recuperar senha</p>

            <form method="POST" action="{{ route('password.email') }}" onsubmit="loadingButton()">
                @csrf

                <div class="mb-4 text-start">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Digite seu e-mail"
                        required
                    >
                </div>

                <button id="btnEnviar" type="submit" class="btn btn-primary w-100 btn-custom">
                    <i class="bi bi-envelope"></i> Enviar link
                </button>

            </form>

        </div>

    </div>

    <script>
        function loadingButton() {
            const btn = document.getElementById('btnEnviar');
            btn.innerHTML = 'Enviando... ⏳';
            btn.disabled = true;
        }
    </script>

</body>

</html>
