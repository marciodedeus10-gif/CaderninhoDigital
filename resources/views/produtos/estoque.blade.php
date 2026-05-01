@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>📦 Estoque: {{ $produto->nome }}</h2>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Coluna de Lançamento -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Nova Movimentação</div>
                <div class="card-body">
                    <p><strong>Estoque Atual:</strong> 
                        <span class="badge {{ $produto->estoque <= 5 ? 'bg-danger' : 'bg-success' }} fs-6">
                            {{ $produto->estoque }} {{ $produto->unidade_medida }}
                        </span>
                    </p>
                    
                    <form action="{{ route('produtos.adicionarMovimentacao', $produto) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Tipo de Movimentação *</label>
                            <select name="tipo" class="form-select" required>
                                <option value="entrada">Entrada (+)</option>
                                <option value="saida">Saída (-)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Quantidade *</label>
                            <input type="number" name="quantidade" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label>Observação (Opcional)</label>
                            <input type="text" name="observacao" class="form-control" placeholder="Ex: Compra NF 123">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrar Movimentação</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Coluna de Histórico -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Histórico de Movimentações</div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Qtd</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movimentacoes as $mov)
                            <tr>
                                <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($mov->tipo == 'entrada')
                                        <span class="badge bg-success">Entrada</span>
                                    @else
                                        <span class="badge bg-danger">Saída</span>
                                    @endif
                                </td>
                                <td>{{ $mov->quantidade }}</td>
                                <td>{{ $mov->observacao ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Nenhuma movimentação registrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3">
                {{ $movimentacoes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
