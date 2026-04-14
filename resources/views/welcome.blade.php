<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Caderninho Digital - Sua Gestão de Vendas Simplificada</title>
<link rel="stylesheet" href="{{ asset('assets/style.css') }}">
<style>
    .carrossel-container {
        position: relative;
    }
    .carousel-caption {
        position: absolute;
        bottom: 20%;
        left: 10%;
        color: white;
        background: rgba(0, 0, 0, 0.4);
        padding: 20px;
        border-radius: 10px;
        backdrop-filter: blur(5px);
        max-width: 400px;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        z-index: 10;
        pointer-events: none;
    }
    .slide.ativo + .carousel-caption {
        opacity: 1;
    }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Caderninho Digital Logo">
    </div>

    <div class="hamburguer" onclick="toggleMenu()">☰</div>

    <!-- MENU DESKTOP -->
    <ul class="menu-desktop">
        <li><a href="{{ route('sobrenos') }}">Sobre nós</a></li>
        <li><a href="{{ route('relatos') }}">Relatos</a></li>
        <li><a href="{{ route('o-app') }}">Dicas</a></li>
        <li><a href="{{ route('beneficios') }}">Vantagens</a></li>
    </ul>

    <div class="login-desktop">
        <a href="{{ route('login') }}" class="btn">Área do Cliente</a>
        <a href="{{ route('register') }}" class="btn cad">Começar Agora</a>
    </div>

    <!-- MENU MOBILE CORRIGIDO -->
    <div class="menu-mobile" id="menuMobile">
        <a href="{{ route('sobrenos') }}">Sobre nós</a>
        <a href="{{ route('relatos') }}">Relatos</a>
        <a href="{{ route('o-app') }}">Dicas</a>
        <a href="{{ route('beneficios') }}">Vantagens</a>
        <a href="{{ route('login') }}" class="btn">Área do Cliente</a>
        <a href="{{ route('register') }}" class="btn cad">Começar Agora</a>
    </div>
</nav>

<!-- Overlay -->
<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<!-- CARROSSEL -->
<section class="carrossel-container">
    <div class="carrossel">
        <img src="{{ asset('assets/img/carousel_1.png') }}" class="slide ativo">
        <div class="carousel-caption">
            <h3>Dashboard Financeiro</h3>
            <p>Acompanhe suas vendas e metas em tempo real com gráficos intuitivos.</p>
        </div>
        
        <img src="{{ asset('assets/img/carousel_2.png') }}" class="slide">
        <div class="carousel-caption">
            <h3>Gestão de Clientes</h3>
            <p>Oportunidades e contatos organizados para você nunca perder um negócio.</p>
        </div>
        
        <img src="{{ asset('assets/img/carousel_3.png') }}" class="slide">
        <div class="carousel-caption">
            <h3>Sucesso Garantido</h3>
            <p>A ferramenta perfeita para pequenas e médias empresas crescerem.</p>
        </div>
    </div>
</section>

<!-- SLOGAN -->
<section class="slogan" id="sobre">
    <h1>Controle de Vendas Simples e Totalmente Digital.<br>
    Transforme a gestão do seu negócio hoje mesmo.</h1>
    <p>Organize clientes, produtos e serviços. Acompanhe do dia a dia ao fechamento de grandes oportunidades.</p>
</section>

<!-- PLANOS -->
<section class="planos" id="planos">
    <h2>Nossos Planos</h2>
    <div class="cards">
        <div class="card">
            <h3>Plano Bronze</h3>
            <p>Essencial para autônomos: controle de vendas e estoque básico.</p>
            <button onclick="contratar('Bronze')">Assinar</button>
        </div>
        <div class="card destaque">
            <h3>Plano Prata</h3>
            <p>A escolha ideal: CRM completo, gestão de oportunidades e metas.</p>
            <button onclick="contratar('Prata')">Assinar</button>
        </div>
        <div class="card">
            <h3>Plano Ouro</h3>
            <p>Business total: Relatórios avançados, múltiplos usuários e prioridade.</p>
            <button onclick="contratar('Ouro')">Assinar</button>
        </div>
    </div>
</section>

<!-- SCRIPT -->
<script>
function toggleMenu() {
    const menu = document.getElementById("menuMobile");
    const overlay = document.getElementById("overlay");

    menu.classList.toggle("ativo");
    overlay.classList.toggle("ativo");
}

// Carrossel simples
let slides = document.querySelectorAll('.slide');
let index = 0;
setInterval(() => {
    slides[index].classList.remove('ativo');
    index = (index + 1) % slides.length;
    slides[index].classList.add('ativo');
}, 4000);

// Função de exemplo
function contratar(plano) {
    alert('Você selecionou o plano: ' + plano);
}

//
function toggleMenu() {
    const menu = document.getElementById("menuMobile");
    const overlay = document.getElementById("overlay");

    menu.classList.toggle("ativo");
    overlay.classList.toggle("ativo");

    // Garante que links ficam clicáveis
    if (menu.classList.contains("ativo")) {
        menu.style.pointerEvents = "auto";
    } else {
        menu.style.pointerEvents = "none";
    }
}
</script>

</body>
</html>
