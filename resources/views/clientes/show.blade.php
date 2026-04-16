@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb / Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page text-muted">{{ $cliente->nome }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">Visualizar Cliente</h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning shadow-sm">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Perfil do Cliente -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden h-100" style="border-radius: 20px;">
                <div class="card-header bg-primary py-4 text-center border-0">
                    <div class="avatar-circle mx-auto mb-3 shadow" style="width: 100px; height: 100px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; color: #1E3A8A;">
                        {{ strtoupper(substr($cliente->nome, 0, 1)) }}
                    </div>
                    <h4 class="text-white mb-0 fw-bold">{{ $cliente->nome }}</h4>
                    <span class="badge {{ $cliente->ativo ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 mt-2">
                        {{ $cliente->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Contato</label>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 text-primary bg-light p-2 rounded">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <span class="d-block fw-semibold text-dark">{{ $cliente->telefone ?? 'Não informado' }}</span>
                                <small class="text-muted">Telefone</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 text-primary bg-light p-2 rounded">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <span class="d-block fw-semibold text-dark text-truncate d-inline-block" style="max-width: 200px;">{{ $cliente->email ?? 'Não informado' }}</span>
                                <small class="text-muted d-block">E-mail</small>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Endereço</label>
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-box me-3 text-primary bg-light p-2 rounded">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <span class="d-block fw-semibold text-dark">
                                    {{ $cliente->endereco }}{{ $cliente->numero ? ', ' . $cliente->numero : '' }}
                                </span>
                                <small class="text-muted">{{ $cliente->bairro }}, {{ $cliente->cidade }} - {{ $cliente->estado }}</small>
                                <div class="small text-muted mt-1">CEP: {{ $cliente->cep }}</div>
                            </div>
                        </div>
                    </div>

                    @if($cliente->observacoes)
                    <div class="mt-4">
                        <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Observações</label>
                        <p class="text-muted small mb-0">{{ $cliente->observacoes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Histórico de Compras -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2 text-primary"></i> Histórico de Compras
                    </h5>
                    <span class="badge bg-light text-primary rounded-pill px-3">{{ $cliente->vendas->count() }} {{ $cliente->vendas->count() == 1 ? 'Venda' : 'Vendas' }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Data</th>
                                    <th>Produtos / Serviços</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Total</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cliente->vendas as $venda)
                                <tr>
                                    <td class="ps-4">
                                        <span class="d-block fw-semibold text-dark">{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</span>
                                        <small class="text-muted">#{{ $venda->id }}</small>
                                    </td>
                                    <td>
                                        <div class="small">
                                            @foreach($venda->itens as $item)
                                                <div class="mb-1">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill small px-2">
                                                        {{ $item->quantidade }}x
                                                    </span>
                                                    <span class="text-dark">
                                                        {{ $item->produto->nome ?? ($item->servico->nome ?? 'Item desconhecido') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($venda->status) {
                                                'finalizada', 'paga', 'Finalizada' => 'bg-success',
                                                'aberta', 'Aberta' => 'bg-primary',
                                                'cancelada', 'Cancelada' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-3 small">
                                            {{ ucfirst($venda->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-dark pe-4">
                                        R$ {{ number_format($venda->total, 2, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Ver Detalhes">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-cart-x display-1 opacity-25"></i>
                                        </div>
                                        <h6 class="text-muted">Nenhuma compra registrada para este cliente.</h6>
                                        <a href="{{ route('vendas.create', ['cliente_id' => $cliente->id]) }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="bi bi-plus-lg me-1"></i> Nova Venda
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom utility classes */
    .bg-primary-subtle { background-color: rgba(30, 58, 138, 0.1); }
    .border-primary-subtle { border-color: rgba(30, 58, 138, 0.2) !important; }

    /* Fix table cell white-space if too long */
    .table td { vertical-align: middle; }

    /* Dark mode adjustments integration */
    body.dark-mode .card { background-color: #1a1a2e !important; border-color: #2a2a4a !important; }
    body.dark-mode .bg-white { background-color: #1a1a2e !important; }
    body.dark-mode .text-dark { color: #e0e0f0 !important; }
    body.dark-mode .bg-light { background-color: rgba(255,255,255,0.05) !important; }
    body.dark-mode .text-muted { color: #a0a0c0 !important; }
    body.dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.02); }
    body.dark-mode .breadcrumb-item.active { color: #e0e0f0; }
    body.dark-mode .avatar-circle { background-color: #0f1f55 !important; color: #fff !important; }
    body.dark-mode .icon-box { background-color: rgba(37, 99, 235, 0.1) !important; color: #60a5fa !important; }
    body.dark-mode .btn-light { background-color: #2a2a4a; border-color: #3a3a5a; color: #fff; }
    body.dark-mode .btn-light:hover { background-color: #3a3a5a; }
</style>
@endsection
