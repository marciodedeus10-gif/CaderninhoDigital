@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pedido de Compra #{{ $compra->id }}</h2>
        <div>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">Voltar</a>
            @if($compra->status == 'pendente' && $compra->itens->count() > 0)
                <form action="{{ route('compras.receber', $compra) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmar o recebimento? Isso dará entrada nos produtos no estoque imediatamente.')">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Receber Pedido</button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Detalhes do Pedido</div>
                <div class="card-body">
                    <p><strong>Fornecedor:</strong> {{ $compra->fornecedor->nome ?? 'N/A' }}</p>
                    <p><strong>Data Compra:</strong> {{ $compra->data_compra->format('d/m/Y') }}</p>
                    <p><strong>Status:</strong> 
                        @if($compra->status == 'pendente')
                            <span class="badge bg-warning text-dark">Pendente</span>
                        @else
                            <span class="badge bg-success">Recebido</span>
                        @endif
                    </p>
                    <hr>
                    <h4 class="text-success fw-bold">Total: R$ {{ number_format($compra->total, 2, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Itens do Pedido</div>
                <div class="card-body">
                    
                    @if($compra->status == 'pendente')
                    <form action="{{ route('compras.addItem', $compra) }}" method="POST" class="row g-2 mb-4 bg-light p-3 rounded">
                        @csrf
                        <div class="col-md-5">
                            <label>Produto</label>
                            <select name="produto_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($produtos as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Qtd</label>
                            <input type="number" name="quantidade" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label>Preço Custo</label>
                            <input type="number" step="0.01" name="preco_unitario" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Adicionar</button>
                        </div>
                    </form>
                    @endif

                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Custo Unit.</th>
                                <th>Subtotal</th>
                                @if($compra->status == 'pendente')
                                <th>Ação</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($compra->itens as $item)
                            <tr>
                                <td>{{ $item->produto->nome ?? 'N/A' }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                @if($compra->status == 'pendente')
                                <td>
                                    <form action="{{ route('compras.removeItem', $item) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum item adicionado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
