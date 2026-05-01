@extends('layouts.app')

@section('header_styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Editar Matéria Prima</h2>
        <a href="{{ route('materia_primas.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('materia_primas.update', $materia_prima->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $materia_prima->nome) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Código SKU</label>
                        <input type="text" name="codigo_sku" class="form-control" value="{{ old('codigo_sku', $materia_prima->codigo_sku) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Unidade de Medida *</label>
                        <select name="unidade_medida" id="unidade_medida" class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="KG" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                            <option value="G" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'G' ? 'selected' : '' }}>Grama (G)</option>
                            <option value="LT" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'LT' ? 'selected' : '' }}>Litro (LT)</option>
                            <option value="ML" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'ML' ? 'selected' : '' }}>Mililitro (ML)</option>
                            <option value="UN" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'UN' ? 'selected' : '' }}>Unidade (UN)</option>
                            <option value="CX" {{ old('unidade_medida', $materia_prima->unidade_medida) == 'CX' ? 'selected' : '' }}>Caixa (CX)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Custo Unitário (R$) *</label>
                        <input type="number" step="0.01" min="0" name="custo_unitario" class="form-control" value="{{ old('custo_unitario', $materia_prima->custo_unitario) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estoque Atual *</label>
                        <input type="number" step="0.01" min="0" name="estoque_atual" id="estoque_atual" class="form-control" value="{{ old('estoque_atual', $materia_prima->estoque_atual) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estoque Mínimo</label>
                        <input type="number" step="0.01" min="0" name="estoque_minimo" id="estoque_minimo" class="form-control" value="{{ old('estoque_minimo', $materia_prima->estoque_minimo) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fornecedor</label>
                        <select name="fornecedor_id" id="fornecedor_id" class="form-select">
                            <option value="">Pesquisar fornecedor...</option>
                            @foreach($fornecedores as $forn)
                                <option value="{{ $forn->id }}" {{ old('fornecedor_id', $materia_prima->fornecedor_id) == $forn->id ? 'selected' : '' }}>{{ $forn->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $materia_prima->descricao) }}</textarea>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" {{ old('ativo', $materia_prima->ativo) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Matéria Prima Ativa</label>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#fornecedor_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Digite para buscar um fornecedor...",
            noResultsText: "Nenhum fornecedor encontrado"
        });

        const unidade = document.getElementById('unidade_medida');
        const estoqueAtual = document.getElementById('estoque_atual');
        const estoqueMinimo = document.getElementById('estoque_minimo');

        function normalizeValue(input) {
            if (!input) return;
            input.value = input.value.toString().replace(',', '.');
        }

        function updateSteps() {
            if (!unidade) return;
            const isUnit = unidade.value === 'UN';
            const stepValue = isUnit ? 1 : 0.01;
            if (estoqueAtual) {
                estoqueAtual.step = stepValue;
                normalizeValue(estoqueAtual);
            }
            if (estoqueMinimo) {
                estoqueMinimo.step = stepValue;
                normalizeValue(estoqueMinimo);
            }
        }

        if (unidade) {
            unidade.addEventListener('change', updateSteps);
            updateSteps();
        }
    });
</script>
