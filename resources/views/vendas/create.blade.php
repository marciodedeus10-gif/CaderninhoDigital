<!DOCTYPE html>


@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="mb-3">
<label>Produto</label>
<select name="produto_id" class="form-control">
@foreach($produtos as $produto)
<option value="{{ $produto->id }}">{{ $produto->nome }}</option>
@endforeach
</select>
</div>

<div class="mb-3">
<label>Quantidade</label>
<input type="number" name="quantidade" class="form-control">
</div>

<div class="mb-3">
<label>Valor</label>
<input type="text" name="valor" class="form-control">
</div>

<div class="mb-3">
<label>Desconto</label>
<input type="text" name="desconto_item" class="form-control">
</div>

<div class="mb-3">
<label>Total</label>
<input type="text" name="total" class="form-control">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#cliente').select2({
        placeholder: "Pesquisar cliente"
    });
});
</script>

@endsection
