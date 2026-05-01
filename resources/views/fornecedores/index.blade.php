@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Fornecedores</h2>
        <a href="{{ route('fornecedores.create') }}" class="btn btn-primary">Novo Fornecedor</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>CNPJ/CPF</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fornecedores as $forn)
                    <tr>
                        <td>{{ $forn->nome }}</td>
                        <td>{{ $forn->cnpj_cpf ?? '-' }}</td>
                        <td>{{ $forn->telefone ?? '-' }}</td>
                        <td>
                            @if($forn->ativo)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-danger">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('fornecedores.edit', $forn) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('fornecedores.destroy', $forn) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Nenhum fornecedor cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $fornecedores->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
