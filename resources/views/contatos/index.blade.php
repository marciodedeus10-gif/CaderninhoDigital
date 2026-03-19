<a href="{{ route('contatos.create') }}">Novo Contato</a>

@foreach ($contatos as $contato)
    <div style="margin-bottom: 10px;">
        <strong>{{ $contato->nome }}</strong> - {{ $contato->telefone ?? 'Não informado' }}

        <br>

        <a href="{{ route('contatos.edit', $contato) }}">Editar</a>

        <form action="{{ route('contatos.destroy', $contato) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Excluir</button>
        </form>
        <button type="submit" onclick="return confirm('Tem certeza?')">
            Excluir
        </button>
    </div>
@endforeach