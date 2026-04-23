@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Pedidos de Compra</h2>
        <a href="{{ route('compras.create') }}" class="btn btn-primary">Novo Pedido</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Fornecedor</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compras as $compra)
                    <tr>
                        <td>#{{ $compra->id }}</td>
                        <td>{{ $compra->fornecedor->nome ?? 'N/A' }}</td>
                        <td>{{ $compra->data_compra->format('d/m/Y') }}</td>
                        <td class="fw-bold">R$ {{ number_format($compra->total, 2, ',', '.') }}</td>
                        <td>
                            @if($compra->status == 'pendente')
                                <span class="badge bg-warning text-dark">Pendente</span>
                            @elseif($compra->status == 'recebido')
                                <span class="badge bg-success">Recebido</span>
                            @else
                                <span class="badge bg-danger">Cancelado</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('compras.show', $compra) }}" class="btn btn-info btn-sm text-white">Visualizar/Itens</a>
                            @if($compra->status == 'pendente')
                                <form action="{{ route('compras.destroy', $compra) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Nenhum pedido de compra encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $compras->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
