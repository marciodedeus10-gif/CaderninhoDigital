@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">

    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5>Total de Vendas</h5>
                <h3>R$ {{ number_format($totalVendas ?? 0, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5>Total de Clientes</h5>
                <h3>{{ $totalClientes ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5>Total de Produtos</h5>
                <h3>{{ $totalProdutos ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection