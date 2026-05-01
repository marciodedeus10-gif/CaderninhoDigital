@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Editar Produto</h2>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><h5 class="mb-0">Dados do Produto</h5></div>
                <div class="card-body">
                    <form action="{{ route('produtos.update', $produto) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('produtos.form')
                        <div class="text-end mt-3">
                            <button class="btn btn-primary">Atualizar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><h5 class="mb-0">Ficha Técnica / Receita</h5></div>
                <div class="card-body">
                    <form action="{{ route('ficha.produto.store', $produto) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Matéria Prima</label>
                            <select name="materia_prima_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($materiaPrimas as $mp)
                                    <option value="{{ $mp->id }}">{{ $mp->nome }} ({{ $mp->unidade_medida }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2 align-items-end">
                            <div class="col">
                                <label class="form-label">Qtd. Gasta</label>
                                <input type="text" name="quantidade" class="form-control" placeholder="Ex: 0,5" required>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-success">Adicionar</button>
                            </div>
                        </div>
                    </form>

                    <h6 class="border-bottom pb-2">Matérias Primas Vinculadas</h6>
                    <ul class="list-group list-group-flush">
                        @forelse($produto->fichaTecnicas as $ficha)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <strong>{{ $ficha->materiaPrima->nome }}</strong><br>
                                    <small class="text-muted">Gasto: {{ number_format($ficha->quantidade, 3, ',', '.') }} {{ $ficha->materiaPrima->unidade_medida }} / unidade</small>
                                </div>
                                <form action="{{ route('ficha.destroy', $ficha->id) }}" method="POST" onsubmit="return confirm('Remover item da ficha técnica?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-muted text-center py-3">
                                Nenhuma matéria prima vinculada.<br>
                                <small>Nenhum estoque será abatido além do próprio produto.</small>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
