@extends('layouts.app')

@section('content')

<div class="container">

<h2>Vendas</h2>

<a href="{{ route('vendas.create') }}" class="btn btn-primary">
Nova Venda
</a>

<br><br>

<table class="table">

<tr>
<th>ID</th>
<th>Cliente</th>
<th>Status</th>
<th>Total</th>
<th>Ações</th>
</tr>

@foreach($vendas as $venda)

<tr>

<td>{{ $venda->id }}</td>

<td>{{ $venda->cliente->nome ?? '' }}</td>

<td>{{ $venda->status }}</td>

<td>R$ {{ $venda->total }}</td>

<td>

<a href="{{ route('vendas.show',$venda->id) }}" class="btn btn-info">
Abrir
</a>

</td>

</tr>

@endforeach

</table>

</div>

@endsection
