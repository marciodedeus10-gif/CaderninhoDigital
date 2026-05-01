<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vantagens - Caderninho Digital</title>

    <style>
        html {
            scroll-padding-top: 120px;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #333;
        }

        /* ======== NAVBAR ======== */
        .navbar {
            width: 100%;
            padding: 10px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(45deg, #4364f7, #6fb1fc, #3f51b5);
            color: white;
            height: 80px;
            position: relative;
            z-index: 2000;
        }

        .navbar .logo img {
            height: 190px;
            width: auto;
            object-fit: contain;
        }

        .navbar nav {
            display: flex;
            align-items: center;
        }

        .navbar nav a {
            text-decoration: none;
            color: white;
            font-size: 20px;
            font-weight: 600;
            padding: 8px 15px;
            white-space: nowrap;
            transition: 0.3s;
        }

        .navbar nav a:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1100px;
            margin: 130px auto 60px;
            padding: 0 20px;
        }

        /* ================= MOBILE ================= */
        @media(max-width: 768px) {
            .navbar nav {
                display: none;
            }

            .hamburger {
                display: block;
                cursor: pointer;
                width: 32px;
            }

            .hamburger div {
                height: 4px;
                width: 100%;
                background: white;
                margin: 6px 0;
                border-radius: 4px;
                transition: 0.3s;
            }

            .mobile-menu {
                display: none;
                position: fixed;
                top: 90px;
                right: 0;
                width: 70%;
                background: white;
                box-shadow: -4px 0 12px rgba(0, 0, 0, 0.12);
                padding: 20px;
                z-index: 2000;
                border-radius: 0 0 0 16px;
            }

            .mobile-menu a {
                display: block;
                font-size: 18px;
                color: #333;
                text-decoration: none;
                margin: 20px 0;
                font-weight: 600;
            }
        }

        h2.section-title {
            font-size: 38px;
            text-align: center;
            margin-bottom: 50px;
            color: #1f1f1f;
            font-weight: 800;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .step {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: 0.3s;
        }

        .step:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .step-icon {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .step h3 {
            font-size: 22px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .step p {
            font-size: 15px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- ======== NAVBAR ======== -->
    <header class="navbar">
        <div class="logo">
             <a href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            </a>
        </div>

        <nav>
            <a href="{{ url('/') }}">Voltar</a>
        </nav>

        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </header>

    <!-- MENU MOBILE -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}" onclick="toggleMenu()">Menu Inicial</a>
        <a href="{{ url('/#como-funciona') }}" onclick="toggleMenu()">Como Funciona</a>
        <a href="{{ route('beneficios') }}" onclick="toggleMenu()">Benefícios</a>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>

    <!-- =================== CONTEÚDO =================== -->

    <div class="container" id="beneficios">
        <h2 class="section-title">Vantagens do Caderninho Digital</h2>

        <div class="steps">
            <div class="step">
                <div class="step-icon">💰</div>
                <h3>Controle de Vendas</h3>
                <p>Registre cada transação e acompanhe o crescimento do seu faturamento instantaneamente.</p>
            </div>

            <div class="step">
                <div class="step-icon">📈</div>
                <h3>Análise de Desempenho</h3>
                <p>Relatórios detalhados para você entender quais produtos e serviços trazem mais retorno.</p>
            </div>

            <div class="step">
                <div class="step-icon">🤝</div>
                <h3>Gestão de Oportunidades</h3>
                <p>Mantenha um histórico de negociações e nunca esqueça de fazer um follow-up.</p>
            </div>

            <div class="step">
                <div class="step-icon">📁</div>
                <h3>Catálogo Digital</h3>
                <p>Organize seus produtos e serviços de forma prática para facilitar o dia a dia.</p>
            </div>
        </div>
    </div>

</body>
</html>
