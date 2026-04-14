<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatos de Usuários</title>

    <link rel="stylesheet" href="{{ asset('assets/relatos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<!-- ======================= NAVBAR ======================= -->
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

    <!-- LOGIN DESKTOP -->
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

<!-- OVERLAY PARA FECHAR O MENU -->
<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<!-- BACKGROUND -->
<div class="background"></div>

<!-- ======================= HERO ======================= -->
<section class="hero fade-in">
    <h1>Relatos de Quem Confia em Nosso Cuidado</h1>
    <p>Experiências reais de idosos e familiares que utilizam nosso monitoramento.</p>
</section>

<!-- ======================= GRÁFICO ======================= -->
<section class="grafico-section fade-in">
    <h2>Indicadores Reais de Segurança e Monitoramento</h2>

    <div class="grafico-container">
        <canvas id="graficoDesempenho"></canvas>
    </div>
</section>

<!-- ======================= RELATOS ======================= -->
<section class="container-relatos fade-in">

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa1.jpg') }}">
        <h3>Maria Souza <span class="idade">72 anos • Penápolis-SP</span></h3>
        <div class="estrelas">★★★★★</div>
        <p>"O sistema já avisou minha filha quando tive tonturas. A resposta rápida me trouxe segurança que nunca tive antes."</p>
    </div>

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa2.jpg') }}">
        <h3>Antônio Ribeiro <span class="idade">81 anos • Birigui-SP</span></h3>
        <div class="estrelas">★★★★☆</div>
        <p>"Os alertas de remédios salvaram meu tratamento. Eu vivia esquecendo, agora nunca mais."</p>
    </div>

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa3.jpg') }}">
        <h3>Helena Martins <span class="idade">68 anos • Araçatuba-SP</span></h3>
        <div class="estrelas">★★★★★</div>
        <p>"O app detectou uma queda que sofri no banheiro e avisou meu filho imediatamente. Sou eternamente grata."</p>
    </div>

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa4.jpg') }}">
        <h3>José Farias <span class="idade">82 anos • Bauru-SP</span></h3>
        <div class="estrelas">★★★★★</div>
        <p>"Depois que comecei a usar, nunca mais fiquei sozinho em momentos críticos. A sensação de segurança é real."</p>
    </div>

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa5.jpg') }}">
        <h3>Ana Ribeiro <span class="idade">74 anos • Sorocaba-SP</span></h3>
        <div class="estrelas">★★★★☆</div>
        <p>"Minha família finalmente fica tranquila quando estou sozinha. É como ter um anjo guardião digital."</p>
    </div>

    <div class="relato-card">
        <img src="{{ asset('assets/img/pessoa6.jpg') }}">
        <h3>Carlos Mendes <span class="idade">70 anos • Campinas-SP</span></h3>
        <div class="estrelas">★★★★★</div>
        <p>"O sistema já evitou duas quedas graves me alertando sobre tontura. Incrível tecnologia."</p>
    </div>

</section>

<!-- ======================= SCRIPTS ======================= -->
<script>
function toggleMenu() {
    const menu = document.getElementById("menuMobile");
    const overlay = document.getElementById("overlay");

    menu.classList.toggle("ativo");
    overlay.classList.toggle("ativo");
}

/* Gráfico Chart.js */
const ctx = document.getElementById('graficoDesempenho');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            'Quedas Detectadas (27%)',
            'Vidas Salvas (18%)',
            'Alertas Preventivos (45%)',
            'Eventos Ignorados (10%)'
        ],
        datasets: [{
            data: [27, 18, 45, 10],
            backgroundColor: [
                '#ff5252',
                '#4caf50',
                '#2196f3',
                '#b0bec5'
            ],
            borderWidth: 2,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: "white",
                    font: { size: 15 }
                }
            }
        }
    }
});
    // Garante que links ficam clicáveis
    if (menu.classList.contains("ativo")) {
        menu.style.pointerEvents = "auto";
    } else {
        menu.style.pointerEvents = "none";
    }

</script>

</body>
</html>
