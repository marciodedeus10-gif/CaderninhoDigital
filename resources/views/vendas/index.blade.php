@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Vendas</h2>
            <p class="text-muted small mb-0">Histórico completo de transações</p>
        </div>
        <a href="{{ route('vendas.create') }}" class="btn btn-success shadow-sm px-4 py-2" style="border-radius: 10px;">
            <i class="bi bi-plus-circle me-1"></i> Nova Venda
        </a>
    </div>

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('vendas.index') }}" class="row g-2 align-items-end">
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">A partir de:</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted p-1 px-2"><i class="bi bi-calendar" style="font-size: 0.8rem;"></i></span>
                        <input type="date" name="data_de" class="form-control border-start-0" value="{{ request('data_de') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Até:</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted p-1 px-2"><i class="bi bi-calendar" style="font-size: 0.8rem;"></i></span>
                        <input type="date" name="data_ate" class="form-control border-start-0" value="{{ request('data_ate') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Ordenar por</label>
                    <select name="sort" class="form-select form-select-sm">
                        <option value="recentes" {{ request('sort') == 'recentes' ? 'selected' : '' }}>📅 Recentes</option>
                        <option value="antigas" {{ request('sort') == 'antigas' ? 'selected' : '' }}>📅 Antigas</option>
                        <option value="alfabetica" {{ request('sort') == 'alfabetica' ? 'selected' : '' }}>🔤 Nome Cliente</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros">
                        <i class="bi bi-x-lg"></i> Limpar
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- LISTA DE VENDAS --}}
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendas as $venda)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $venda->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2 bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($venda->cliente->nome ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="text-dark fw-semibold">{{ $venda->cliente->nome ?? 'Cliente não encontrado' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark small">{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</span>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Criada em: {{ $venda->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match(strtolower($venda->status)) {
                                            'pago', 'finalizada', 'concluída' => 'bg-success',
                                            'pendente', 'aguardando' => 'bg-warning text-dark',
                                            'cancelada' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-2" style="font-size: 0.75rem;">
                                        {{ ucfirst($venda->status) }}
                                    </span>
                                </td>
                                <td class="fw-bold text-primary">
                                    R$ {{ number_format($venda->total, 2, ',', '.') }}
                                </td>
                                <td class="text-center pe-3">
                                    <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border" title="Abrir Detalhes">
                                        <i class="bi bi-box-arrow-in-right me-1 text-primary"></i> Abrir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="bi bi-cart-x display-1 opacity-25"></i>
                                    </div>
                                    <h5 class="text-muted">Nenhuma venda encontrada com esses filtros.</h5>
                                    <a href="{{ route('vendas.index') }}" class="btn btn-sm btn-outline-primary mt-2">Limpar Filtros</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- PAGINAÇÃO --}}
        @if($vendas->hasPages())
            <div class="card-footer bg-white border-0 py-3 pe-4">
                <div class="d-flex justify-content-end">
                    {{ $vendas->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<style>
    body.dark-mode .card { background-color: #1a1a2e !important; }
    body.dark-mode .bg-white { background-color: #1a1a2e !important; }
    body.dark-mode .text-dark { color: #e0e0f0 !important; }
    body.dark-mode .bg-light { background-color: rgba(255,255,255,0.05) !important; }
    body.dark-mode .text-muted { color: #a0a0c0 !important; }
    body.dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.02); }
    body.dark-mode .btn-light { background-color: #2a2a4a; border-color: #3a3a5a; color: #fff; }
    body.dark-mode .btn-light i { color: #60a5fa !important; }
    body.dark-mode .form-control, body.dark-mode .form-select, body.dark-mode .input-group-text {
        background-color: #0f0f1a;
        border-color: #2a2a4a;
        color: #e0e0f0;
    }
    
    .table td { border: none; }
    .badge { letter-spacing: 0.5px; }

    /* Custom pagination colors for dark mode */
    body.dark-mode .pagination .page-link {
        background-color: #1a1a2e;
        border-color: #2a2a4a;
        color: #60a5fa;
    }
    body.dark-mode .pagination .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }
</style>
@endsection
