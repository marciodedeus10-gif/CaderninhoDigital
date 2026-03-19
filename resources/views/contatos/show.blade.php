<div class="card p-3">
    <h3>{{ $contato->nome }}</h3>

    <p><strong>Telefone:</strong> {{ $contato->telefone ?? 'Não informado' }}</p>
    <p><strong>Email:</strong> {{ $contato->email ?? 'Não informado' }}</p>
    <p><strong>Observação:</strong> {{ $contato->observacao ?? 'Sem observações' }}</p>
</div>