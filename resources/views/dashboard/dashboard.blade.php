@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Dashboard</h2>

    @if($produtosEstoqueBaixo->count() > 0)
    <div class="alert alert-danger shadow-sm border-0 border-start border-danger border-4">
        <h5 class="fw-bold"><i class="fas fa-exclamation-triangle"></i> Atenção: Estoque Baixo!</h5>
        <p class="mb-0">Você possui <strong>{{ $produtosEstoqueBaixo->count() }}</strong> produtos que atingiram ou estão abaixo do estoque mínimo. Recomendamos fazer um Pedido de Compra.</p>
        <hr>
        <ul class="mb-0">
            @foreach($produtosEstoqueBaixo->take(5) as $prod)
                <li>{{ $prod->nome }} - Restam apenas <strong>{{ $prod->estoque }}</strong> {{ $prod->unidade_medida }}</li>
            @endforeach
            @if($produtosEstoqueBaixo->count() > 5)
                <li><em>E mais {{ $produtosEstoqueBaixo->count() - 5 }} outros produtos...</em></li>
            @endif
        </ul>
    </div>
    @endif

    <div class="row">

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase opacity-75">Total de Clientes</h6>
                    <h2 class="fw-bold">{{ $totalClientes }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase opacity-75">Saldo de Caixa (Mês)</h6>
                    <h2 class="fw-bold">R$ {{ number_format($saldoCaixa, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase opacity-75">Top Produto</h6>
                    <h2 class="fw-bold text-truncate" title="{{ $produtosMaisVendidos->first()->produto->nome ?? 'Nenhum' }}">
                        {{ $produtosMaisVendidos->first()->produto->nome ?? 'Nenhum' }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase opacity-75">Top Serviço</h6>
                    <h2 class="fw-bold text-truncate" title="{{ $servicosMaisEfetuados->first()->servico->nome ?? 'Nenhum' }}">
                        {{ $servicosMaisEfetuados->first()->servico->nome ?? 'Nenhum' }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-chart-line me-1"></i> Ranking de Produtos
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Produto</th>
                                <th class="text-end">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produtosMaisVendidos as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}º</td>
                                <td class="fw-bold text-primary">{{ $item->produto->nome ?? 'N/A' }}</td>
                                <td class="text-end">{{ $item->total }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Nenhum dado</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-tools me-1"></i> Ranking de Serviços
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Serviço</th>
                                <th class="text-end">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servicosMaisEfetuados as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}º</td>
                                <td class="fw-bold text-success">{{ $item->servico->nome ?? 'N/A' }}</td>
                                <td class="text-end">{{ $item->total }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Nenhum dado</td></tr>
                            @endforelse
                        </tbody>
                    </table>
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
