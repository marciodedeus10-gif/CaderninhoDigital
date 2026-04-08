@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-primary mb-0">
                <i class="bi bi-lightbulb-fill me-2"></i>Oportunidades do Dia
            </h2>
            <p class="text-muted mb-0">Gerencie seus contatos e negociações agendadas para hoje, {{ date('d/m/Y') }}.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaOportunidade">
                <i class="bi bi-plus-lg me-2"></i>Nova Oportunidade
            </button>
        </div>
    </div>

    {{-- Oportunidades de Hoje --}}
    <div class="row">
        @forelse($oportunidadesHoje as $op)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm transition-hover">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <span class="badge bg-{{ $op->tipo == 'Venda' ? 'success' : ($op->tipo == 'Retorno' ? 'primary' : 'warning') }} rounded-pill px-3">
                        {{ $op->tipo }}
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $op->id }}"><i class="bi bi-pencil me-2"></i>Editar</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('oportunidades.destroy', $op->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Excluir</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-1">{{ $op->cliente->nome ?? 'Cliente N/A' }}</h5>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-telephone me-1"></i> {{ $op->cliente->telefone ?? 'Sem telefone' }}
                    </p>
                    <div class="p-3 bg-light rounded-3 text-dark mb-0">
                        <p class="mb-0 small fst-italic">"{{ $op->descricao ?? 'Sem observações' }}"</p>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <div class="d-grid">
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $op->cliente->telefone ?? '') }}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp me-2"></i>Entrar em Contato
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Editar --}}
        <div class="modal fade" id="modalEditar{{ $op->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white border-0">
                        <h5 class="modal-title fw-bold">Editar Oportunidade</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('oportunidades.update', $op->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cliente</label>
                                <select name="cliente_id" class="form-select border-0 bg-light" required>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ $op->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <select name="tipo" class="form-select border-0 bg-light" required>
                                    <option value="Venda" {{ $op->tipo == 'Venda' ? 'selected' : '' }}>Venda</option>
                                    <option value="Retorno" {{ $op->tipo == 'Retorno' ? 'selected' : '' }}>Retorno</option>
                                    <option value="Cobranca" {{ $op->tipo == 'Cobranca' ? 'selected' : '' }}>Cobrança</option>
                                    <option value="Outro" {{ $op->tipo == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data do Contato</label>
                                <input type="date" name="data_contato" class="form-control border-0 bg-light" value="{{ $op->data_contato }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Observações</label>
                                <textarea name="descricao" class="form-control border-0 bg-light" rows="3">{{ $op->descricao }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="p-5 text-center bg-white rounded-4 shadow-sm">
                <div class="display-1 text-muted opacity-25 mb-3">
                    <i class="bi bi-calendar2-x"></i>
                </div>
                <h4 class="fw-bold">Nenhuma oportunidade para hoje!</h4>
                <p class="text-muted">Relaxe ou busque novas prospecções na sua lista geral abaixo.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Lista Geral --}}
    <div class="card border-0 shadow-sm mt-5 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Todas as Oportunidades</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Cliente</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todasOportunidades as $op)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $op->cliente->nome ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $op->cliente->email ?? '' }}</div>
                            </td>
                            <td>{{ $op->tipo }}</td>
                            <td>{{ \Carbon\Carbon::parse($op->data_contato)->format('d/m/Y') }}</td>
                            <td>
                                @if(\Carbon\Carbon::parse($op->data_contato)->isToday())
                                    <span class="badge bg-success">Hoje</span>
                                @elseif(\Carbon\Carbon::parse($op->data_contato)->isPast())
                                    <span class="badge bg-secondary">Passado</span>
                                @else
                                    <span class="badge bg-primary">Agendado</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $op->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            {{ $todasOportunidades->links() }}
        </div>
    </div>
</div>

{{-- Modal Nova Oportunidade --}}
<div class="modal fade" id="modalNovaOportunidade" tabindex="-1">
    <div class="modal-dialog shadow-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">Nova Oportunidade</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('oportunidades.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente</label>
                        <select name="cliente_id" class="form-select border-0 bg-light" required>
                            <option value="" disabled selected>Selecione um cliente...</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo de Oportunidade</label>
                        <select name="tipo" class="form-select border-0 bg-light" required>
                            <option value="Venda">Venda</option>
                            <option value="Retorno">Retorno</option>
                            <option value="Cobranca">Cobrança</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Data do Contato</label>
                        <input type="date" name="data_contato" class="form-control border-0 bg-light" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Observações / Meta</label>
                        <textarea name="descricao" class="form-control border-0 bg-light" rows="3" placeholder="O que precisa ser feito?"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">Cadastrar Oportunidade</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
