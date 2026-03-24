@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <!-- Título -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Quem Somos</h1>
        <p class="text-muted">Conheça mais sobre o Caderninho Digital</p>
    </div>

    <!-- Sobre -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-bold">Nossa História</h3>
            <p>
                O <strong>Caderninho Digital</strong> nasceu com o objetivo de modernizar a forma como vendedores
                gerenciam seus clientes e vendas. Inspirado no tradicional “caderninho”, o sistema traz
                tecnologia e organização para o dia a dia comercial.
            </p>
            <p>
                Desenvolvido como parte de um estudo de viabilidade e impacto social, o projeto busca
                aumentar a produtividade e fortalecer o relacionamento com clientes.
            </p>
        </div>

        <div class="col-md-6 text-center">
            <img src="https://via.placeholder.com/400x300" class="img-fluid rounded shadow" alt="Sobre">
        </div>
    </div>

    <!-- Missão, Visão, Valores -->
    <div class="row text-center mb-5">

        <div class="col-md-4 mb-3">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-primary">Missão</h4>
                    <p>
                        Facilitar a gestão de clientes e vendas, oferecendo uma ferramenta simples,
                        inteligente e eficiente para vendedores.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-success">Visão</h4>
                    <p>
                        Ser referência em soluções digitais para gestão de relacionamento com clientes,
                        ajudando profissionais a crescerem no mercado.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-danger">Valores</h4>
                    <p>
                        Inovação, simplicidade, foco no cliente, eficiência e compromisso com resultados.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Diferenciais -->
    <div class="mb-5">
        <h3 class="fw-bold text-center mb-4">Por que escolher o Caderninho Digital?</h3>

        <div class="row">

            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✔ Organização completa de clientes</li>
                    <li class="list-group-item">✔ Histórico de interações e vendas</li>
                    <li class="list-group-item">✔ Lembretes automáticos</li>
                </ul>
            </div>

            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✔ Insights inteligentes</li>
                    <li class="list-group-item">✔ Aumento da produtividade</li>
                    <li class="list-group-item">✔ Interface simples e intuitiva</li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Rodapé -->
    <div class="text-center mt-5">
        <p class="text-muted">
            © {{ date('Y') }} Caderninho Digital - Todos os direitos reservados
        </p>
    </div>

</div>

@endsection
