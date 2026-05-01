@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Clientes</h2>
            <p class="text-muted small mb-0">Gerencie sua base de contatos e clientes</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary shadow-sm px-4 py-2" style="border-radius: 10px;">
            <i class="bi bi-person-plus me-1"></i> Novo Cliente
        </a>
    </div>

    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('clientes.index') }}" class="row g-2 align-items-end">
                
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Nome do Cliente</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="nome" list="clientes-datalist" class="form-control border-start-0" placeholder="Ex: João Silva" value="{{ request('nome') }}" autocomplete="off">
                        <datalist id="clientes-datalist">
                            @if(isset($nomesClientes))
                                @foreach ($nomesClientes as $nomeCliente)
                                    <option value="{{ $nomeCliente }}"></option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Cidade</label>
                    <select name="cidade" class="form-select form-select-sm">
                        <option value="">Todas as Cidades</option>
                        @foreach ($cidades as $cidade)
                            <option value="{{ $cidade }}" {{ request('cidade') == $cidade ? 'selected' : '' }}>
                                {{ $cidade }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Bairro</label>
                    <select name="bairro" class="form-select form-select-sm">
                        <option value="">Todos os Bairros</option>
                        @foreach ($bairros as $bairro)
                            <option value="{{ $bairro }}" {{ request('bairro') == $bairro ? 'selected' : '' }}>
                                {{ $bairro }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- LISTA DE CLIENTES --}}
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Nome</th>
                            <th>Cidade / UF</th>
                            <th>Bairro</th>
                            <th>Endereço</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; min-width: 35px;">
                                            {{ strtoupper(substr($cliente->nome, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="d-block fw-semibold text-dark text-truncate" style="max-width: 180px;">{{ $cliente->nome }}</span>
                                            <small class="text-muted">{{ $cliente->telefone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $cliente->cidade }}</span>
                                    <small class="text-muted d-block">{{ $cliente->estado }}</small>
                                </td>
                                <td>{{ $cliente->bairro }}</td>
                                <td>
                                    <span class="d-block text-truncate text-dark" style="max-width: 250px;">
                                        {{ $cliente->endereco }}{{ $cliente->numero ? ', ' . $cliente->numero : '' }}
                                    </span>
                                    <small class="text-muted">{{ $cliente->cep }}</small>
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Ver Detalhes">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Editar">
                                            <i class="bi bi-pencil text-warning"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Excluir">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="bi bi-people display-1 opacity-25"></i>
                                    </div>
                                    <h5 class="text-muted">Nenhum cliente encontrado.</h5>
                                    @if(request()->anyFilled(['nome', 'cidade', 'bairro']))
                                        <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-primary mt-2">Limpar Filtros</a>
                                    @else
                                        <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-primary mt-2">Cadastrar Primeiro Cliente</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- PAGINAÇÃO --}}
        @if($clientes->hasPages())
            <div class="card-footer bg-white border-0 py-3 pe-4">
                <div class="d-flex justify-content-end">
                    {{ $clientes->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<style>
    /* Custom utility classes */
    body.dark-mode .card { background-color: #1a1a2e !important; }
    body.dark-mode .bg-white { background-color: #1a1a2e !important; }
    body.dark-mode .text-dark { color: #e0e0f0 !important; }
    body.dark-mode .bg-light { background-color: rgba(255,255,255,0.05) !important; }
    body.dark-mode .text-muted { color: #a0a0c0 !important; }
    body.dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.02); }
    body.dark-mode .form-control, body.dark-mode .form-select, body.dark-mode .input-group-text {
        background-color: #0f0f1a;
        border-color: #2a2a4a;
        color: #e0e0f0;
    }
    body.dark-mode .btn-light { background-color: #2a2a4a; border-color: #3a3a5a; color: #fff; }
    body.dark-mode .btn-light:hover { background-color: #3a3a5a; }
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

    /* Fixed table styling */
    .table td { border: none; }
    .pagination { margin-bottom: 0; }
</style>
@endsection
