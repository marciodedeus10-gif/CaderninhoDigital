@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Dashboard</h2>

    <div class="row">

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total de Clientes</h5>
                    <h2>350</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Total de Vendas</h5>
                    <h2>1200</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5>Produto Mais Vendido</h5>
                    <h5>Produto X</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5>Contatos Hoje</h5>
                    <h2>5</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Vendas por mês
                </div>

                <div class="card-body">
                    <canvas id="graficoVendas"></canvas>
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Produtos mais vendidos
                </div>

                <div class="card-body">
                    <canvas id="graficoProdutos"></canvas>
                </div>
            </div>

        </div>

    </div>

    <br>

    <div class="card">

        <div class="card-header">
            Últimas vendas
        </div>

        <div class="card-body">

            <table class="table">

                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Total</th>
                        <th>Data</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>João</td>
                        <td>Produto A</td>
                        <td>100</td>
                        <td>90</td>
                        <td>05/05/2024</td>
                    </tr>

                    <tr>
                        <td>Maria</td>
                        <td>Produto X</td>
                        <td>200</td>
                        <td>200</td>
                        <td>04/05/2024</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

var ctx = document.getElementById('graficoVendas');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Fev','Mar','Abr'],
        datasets: [{
            label: 'Vendas',
            data: [12,19,30,25]
        }]
    }
});

</script>

@endsection
