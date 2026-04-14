<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Como Funciona - Caderninho Digital</title>

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    
    <style>
        /* Ajuste para que o conteúdo não fique escondido atrás da navbar fixa */
body {
    background: #f7f7f7;
    font-family: Arial, sans-serif;
}


        .container {
            max-width: 1100px;
            margin: 20px auto 60px;
            padding: 0 20px;
        }

        h2.section-title {
            font-size: 38px;
            text-align: center;
            margin-bottom: 60px;
            color: #1f1f1f;
            font-weight: 800;
        }

        /* Área dos passos */
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .step {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            text-align: center;
            transition: 0.3s;
        }

        .step:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
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

<!-- ======================= NAVBAR COPIADA DO INDEX ======================= -->
<nav class="navbar">
    <div class="logo">
         <a href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </a>
    </div>

    <div class="hamburguer" onclick="toggleMenu()">☰</div>

    <!-- MENU DESKTOP -->
    <ul class="menu-desktop">
        <li><a href="{{ route('sobrenos') }}">Sobre nós</a></li>
        <li><a href="{{ route('relatos') }}">Relatos</a></li>
        <li><a href="{{ route('o-app') }}">Primeiros Passos</a></li>
        <li><a href="{{ route('beneficios') }}">Benefícios</a></li>

    </ul>

    <div class="login-desktop">
        <a href="{{ route('login') }}" class="btn">Login</a>
        <a href="{{ route('register') }}" class="btn cad">Cadastro</a>
    </div>

    <!-- MENU MOBILE -->
    <div class="menu-mobile" id="menuMobile">
        <a href="{{ url('/#sobre') }}">Sobre nós</a>
        <a href="{{ route('relatos') }}">Relatos</a>
        <a href="{{ route('o-app') }}">Primeiros Passos</a>
        <a href="{{ route('login') }}" class="btn">Login</a>
        <a href="{{ route('register') }}" class="btn cad">Cadastro</a>
    </div>
</nav>

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<!-- ======================= CONTEÚDO ======================= -->
<div class="container" id="como-funciona">
    <h2 class="section-title">Como Funciona</h2>

    <div class="steps">

        <div class="step">
            <div class="step-icon">📦</div>
            <h3>1. Cadastre seus Produtos</h3>
            <p>Adicione fotos, preços e categorias para organizar seu catálogo digital rapidamente.</p>
        </div>

        <div class="step">
            <div class="step-icon">🤝</div>
            <h3>2. Gerencie Clientes</h3>
            <p>Mantenha uma base de dados completa com histórico de compras e contatos.</p>
        </div>

        <div class="step">
            <div class="step-icon">💰</div>
            <h3>3. Registre Vendas</h3>
            <p>Lance vendas de forma simples e aplique descontos ou taxas em segundos.</p>
        </div>

        <div class="step">
            <div class="step-icon">📊</div>
            <h3>4. Analise Resultados</h3>
            <p>Acompanhe seu lucro e crescimento através do dashboard inteligente.</p>
        </div>

    </div>
</div>


<!-- ======================= SCRIPT NAVBAR ======================= -->
<script>
function toggleMenu() {
    const menu = document.getElementById("menuMobile");
    const overlay = document.getElementById("overlay");

    menu.classList.toggle("ativo");
    overlay.classList.toggle("ativo");
}
</script>

</body>
</html>
