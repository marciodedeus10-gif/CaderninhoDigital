@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Fluxo de Caixa</h2>
            <p class="text-muted">Gerencie suas receitas e despesas em um só lugar.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm px-4 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#novoLancamentoModal">
            <i class="bi bi-plus-lg me-2"></i>Novo Lançamento
        </button>
    </div>

    <!-- Cards de Resumo -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-arrow-up-right text-success fs-4"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Este Mês</span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-bold small mb-1">Receitas (Pagas)</h6>
                    <h3 class="fw-bold mb-0 text-success">R$ {{ number_format($receitasMes, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-arrow-down-left text-danger fs-4"></i>
                        </div>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Este Mês</span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-bold small mb-1">Despesas (Pagas)</h6>
                    <h3 class="fw-bold mb-0 text-danger">R$ {{ number_format($despesasMes, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-4">
                            <i class="bi bi-piggy-bank fs-4"></i>
                        </div>
                        <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25 rounded-pill px-3">Saldo Líquido</span>
                    </div>
                    <h6 class="text-white text-opacity-75 text-uppercase fw-bold small mb-1">Balanço Mensal</h6>
                    <h3 class="fw-bold mb-0">R$ {{ number_format($saldoMes, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Tabela -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0">Lançamentos Recentes</h5>
            <form action="{{ route('financeiro.index') }}" method="GET" class="d-flex gap-2">
                <select name="tipo" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">Todos os Tipos</option>
                    <option value="receita" {{ request('tipo') == 'receita' ? 'selected' : '' }}>Receitas</option>
                    <option value="despesa" {{ request('tipo') == 'despesa' ? 'selected' : '' }}>Despesas</option>
                </select>
                <select name="status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                    <option value="">Todos Status</option>
                    <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pagos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                </select>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 text-muted small fw-bold">DESCRIÇÃO</th>
                            <th class="border-0 text-muted small fw-bold">TIPO</th>
                            <th class="border-0 text-muted small fw-bold">VENCIMENTO</th>
                            <th class="border-0 text-muted small fw-bold text-end">VALOR</th>
                            <th class="border-0 text-muted small fw-bold text-center">STATUS</th>
                            <th class="pe-4 border-0 text-muted small fw-bold text-end">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lancamentos as $lanc)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $lanc->descricao }}</div>
                                @if($lanc->venda_id)
                                    <span class="badge bg-light text-dark fw-normal border">Venda #{{ $lanc->venda_id }}</span>
                                @elseif($lanc->compra_id)
                                    <span class="badge bg-light text-dark fw-normal border">Compra #{{ $lanc->compra_id }}</span>
                                @endif
                            </td>
                            <td>
                                @if($lanc->tipo == 'receita')
                                    <span class="text-success small fw-bold text-uppercase"><i class="bi bi-plus-circle me-1"></i>Receita</span>
                                @else
                                    <span class="text-danger small fw-bold text-uppercase"><i class="bi bi-dash-circle me-1"></i>Despesa</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($lanc->data_vencimento)->format('d/m/Y') }}</td>
                            <td class="text-end fw-bold {{ $lanc->tipo == 'receita' ? 'text-success' : 'text-danger' }}">
                                R$ {{ number_format($lanc->valor, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if($lanc->status == 'pago')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Pago</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Pendente</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    @if($lanc->status == 'pendente')
                                    <form action="{{ route('financeiro.baixa', $lanc->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill" title="Dar Baixa">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('financeiro.destroy', $lanc->id) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Nenhum lançamento encontrado.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $lancamentos->links() }}
        </div>
    </div>
</div>

<!-- Modal Novo Lançamento -->
<div class="modal fade" id="novoLancamentoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Novo Lançamento Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">DESCRIÇÃO</label>
                        <input type="text" name="descricao" class="form-control rounded-3" placeholder="Ex: Conta de Luz, Aluguel..." required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">TIPO</label>
                            <select name="tipo" class="form-select rounded-3" required>
                                <option value="despesa">Despesa</option>
                                <option value="receita">Receita</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">VALOR (R$)</label>
                            <input type="number" step="0.01" name="valor" class="form-control rounded-3" placeholder="0,00" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">VENCIMENTO</label>
                            <input type="date" name="data_vencimento" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">STATUS</label>
                            <select name="status" class="form-select rounded-3" required>
                                <option value="pago">Já está pago</option>
                                <option value="pendente">Pendente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Salvar Lançamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
