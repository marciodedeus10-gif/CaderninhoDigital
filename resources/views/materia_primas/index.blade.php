@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Matérias Primas</h2>
        <a href="{{ route('materia_primas.create') }}" class="btn btn-primary">Nova Matéria Prima</a>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Custo</th>
                        <th>Estoque</th>
                        <th>Unidade</th>
                        <th>Fornecedor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materiaPrimas as $mp)
                    <tr>
                        <td>
                            <strong>{{ $mp->nome }}</strong>
                            @if($mp->codigo_sku)
                            <br><small class="text-muted">SKU: {{ $mp->codigo_sku }}</small>
                            @endif
                        </td>
                        <td>R$ {{ number_format($mp->custo_unitario, 2, ',', '.') }}</td>
                        <td>
                            <span class="{{ $mp->estoque_atual <= $mp->estoque_minimo ? 'text-danger fw-bold' : '' }}">
                                {{ number_format($mp->estoque_atual, $mp->unidade_medida === 'UN' ? 0 : 2, ',', '.') }}
                            </span>
                        </td>
                        <td>{{ $mp->unidade_medida }}</td>
                        <td>{{ $mp->fornecedor ? $mp->fornecedor->nome : '-' }}</td>
                        <td>
                            @if($mp->ativo)
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-danger">Inativa</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('materia_primas.edit', $mp) }}" class="btn btn-warning btn-sm">Editar</a>
<a href="{{ route('materia_primas.add_stock_form', $mp) }}" class="btn btn-success btn-sm ms-2">Adicionar estoque</a>
<form action="{{ route('materia_primas.destroy', $mp) }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir esta matéria prima?')">
    @csrf @method('DELETE')
    <button class="btn btn-danger btn-sm">Excluir</button>
</form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Nenhuma matéria prima cadastrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $materiaPrimas->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
