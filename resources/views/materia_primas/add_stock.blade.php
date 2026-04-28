@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Adicionar estoque - {{ $materia_prima->nome }}</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('materia_primas.add_stock', $materia_prima) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Quantidade ({{ $materia_prima->unidade_medida }})</label>
                    <input type="number" step="{{ $materia_prima->unidade_medida === 'UN' ? 1 : 0.01 }}" name="quantidade" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Custo unitário (R$)</label>
                    <input type="number" step="0.01" name="custo" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="confirmar" id="confirmar" value="1" required>
                    <label class="form-check-label" for="confirmar">
                        Confirmar entrada de estoque
                    </label>
                </div>
                <button type="submit" id="btnAddStock" class="btn btn-primary" disabled>Atualizar estoque</button>
                <a href="{{ route('materia_primas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </form>
        </div>
    </div>
    <div class="mt-4">
        <h5>Informações atuais</h5>
        <ul class="list-group">
            <li class="list-group-item"><strong>Estoque atual:</strong> {{ number_format($estoque_atual, $materia_prima->unidade_medida === 'UN' ? 0 : 2, ',', '.') }} {{ $materia_prima->unidade_medida }}</li>
            <li class="list-group-item"><strong>Estoque mínimo:</strong> {{ number_format($materia_prima->estoque_minimo ?? 0, $materia_prima->unidade_medida === 'UN' ? 0 : 2, ',', '.') }} {{ $materia_prima->unidade_medida }}</li>
        </ul>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmarCheckbox = document.getElementById('confirmar');
        const btnAddStock = document.getElementById('btnAddStock');
        const form = btnAddStock.closest('form');

        function toggleButton() {
            btnAddStock.disabled = !confirmarCheckbox.checked;
        }

        if (confirmarCheckbox) {
            confirmarCheckbox.addEventListener('change', toggleButton);
            toggleButton();
        }

        if (form) {
            form.addEventListener('submit', function() {
                btnAddStock.disabled = true;
                btnAddStock.textContent = 'Adicionando...';
            });
        }
    });
</script>@endsection
