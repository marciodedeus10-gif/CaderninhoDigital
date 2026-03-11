<h2>Oportunidades do Dia</h2>

<a href="{{ route('oportunidades.create') }}">Nova Oportunidade</a>

<table border="1">
<tr>
<th>Cliente</th>
<th>Tipo</th>
<th>Data</th>
<th>Ações</th>
</tr>

@foreach($oportunidades as $oportunidade)

<tr>
<td>{{ $oportunidade->cliente_id }}</td>
<td>{{ $oportunidade->tipo }}</td>
<td>{{ $oportunidade->data_contato }}</td>

<td>
<a href="{{ route('oportunidades.edit',$oportunidade->id) }}">Editar</a>

<form action="{{ route('oportunidades.destroy',$oportunidade->id) }}" method="POST">
@csrf
@method('DELETE')
<button type="submit">Excluir</button>
</form>

</td>

</tr>

@endforeach

</table>
