@extends('layouts.app')

@section('content')

<h2>Venda #{{$venda->id}}</h2>

Status: {{$venda->status}}

<hr>



<h4>Adicionar Produto</h4>

<form method="POST" action="{{ route('vendas.addItem',$venda->id) }}">

@csrf

<select name="produto_id">

<option value="">Selecione</option>

@foreach($produtos as $produto)

<option value="{{$produto->id}}">
{{$produto->nome}}
</option>

@endforeach

</select>

<input type="number" name="quantidade" placeholder="Quantidade">

<input type="text" name="preco" placeholder="Preço">

<button class="btn btn-success">
Adicionar
</button>

</form>

<hr>

<h4>Adicionar Serviço</h4>

<form method="POST" action="{{ route('vendas.addItem',$venda->id) }}">

@csrf

<select name="servico_id">

<option value="">Selecione</option>

@foreach($servicos as $servico)

<option value="{{$servico->id}}">
{{$servico->nome}}
</option>

@endforeach

</select>

<input type="number" name="quantidade">

<input type="text" name="preco">

<button class="btn btn-success">
Adicionar
</button>

</form>

<hr>

<h3>Total: R$ {{$venda->total}}</h3>

<form method="POST" action="{{ route('vendas.status',$venda->id) }}">

@csrf

<button class="btn btn-primary">
Finalizar Venda
</button>

</form>

@endsection
