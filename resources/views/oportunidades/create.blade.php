<h2>Nova Oportunidade</h2>

<form action="{{ route('oportunidades.store') }}" method="POST">
@csrf

<label>Cliente</label>
<select name="cliente_id">

@foreach($clientes as $cliente)

<option value="{{ $cliente->id }}">
{{ $cliente->nome }}
</option>

@endforeach

</select>

<label>Tipo</label>
<input type="text" name="tipo">

<label>Descrição</label>
<textarea name="descricao"></textarea>

<label>Data de contato</label>
<input type="date" name="data_contato">

<button type="submit">Salvar</button>

</form>
