@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Dashboard</h2>

    <div class="row">

<div class="col-md-4">
    <div class="card text-white bg-primary mb-3">
        <div class="card-body">
            <h5 class="card-title">Total de Clientes</h5>
            <h3>{{ $totalClientes }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card text-white bg-success mb-3">
        <div class="card-body">
            <h5>Total de Vendas</h5>
            <h2>{{ $totalVendas }}</h2>
        </div>
    </div>
</div>

@forelse($produtosMaisVendidos as $item)
<div class="col-md-3">
    <div class="card text-white bg-warning mb-3">
        <div class="card-body">
            <h5>Produto Mais Vendido</h5>
            <h5>{{ $item->produto->nome ?? 'Nenhum' }} ({{ $item->total }})</h5>
        </div>
    </div>
</div>
@empty
<div class="col-md-3">
    <div class="card text-white bg-warning mb-3">
        <div class="card-body">
            <h5>Produto Mais Vendido</h5>
            <h5>Nenhum</h5>
        </div>
    </div>
</div>
@endforelse

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5>Contatos Hoje</h5>
                    <h2>R$ {{ number_format($totalVendas,2,',','.') }}</h2>
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

                    @foreach($ultimasVendas as $venda)
                    <tr>
                        <td>{{ $venda->cliente->nome ?? 'N/A' }}</td>
                        <td>
                            @if($venda->itens->count() > 1)
                                Vários ({{ $venda->itens->count() }})
                            @else
                                {{ $venda->itens->first()->produto->nome ?? ($venda->itens->first()->servico->nome ?? 'N/A') }}
                            @endif
                        </td>
                        <td>R$ {{ number_format($venda->subtotal, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                        <td>{{ $venda->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach

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
