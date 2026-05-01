<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nome do Produto *</label>
        <input type="text" name="nome" class="form-control"
            value="{{ old('nome', $produto->nome ?? '') }}" required>
    </div>
    
    <div class="col-md-3 mb-3">
        <label>Código / SKU</label>
        <input type="text" name="codigo_sku" class="form-control"
            value="{{ old('codigo_sku', $produto->codigo_sku ?? '') }}">
    </div>

    <div class="col-md-3 mb-3">
        <label>Categoria</label>
        <input type="text" name="categoria" class="form-control"
            value="{{ old('categoria', $produto->categoria ?? '') }}">
    </div>
</div>

<div class="mb-3">
    <label>Descrição</label>
    <textarea name="descricao" class="form-control" rows="2">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label>Preço de Venda *</label>
        <input type="number" step="0.01" name="preco" class="form-control"
            value="{{ old('preco', $produto->preco ?? '') }}" required>
    </div>

    <div class="col-md-3 mb-3">
        <label>Preço de Custo</label>
        <input type="number" step="0.01" name="preco_custo" class="form-control"
            value="{{ old('preco_custo', $produto->preco_custo ?? '') }}">
    </div>

    <div class="col-md-2 mb-3">
        <label>Estoque Atual</label>
        <input type="number" name="estoque" class="form-control"
            value="{{ old('estoque', $produto->estoque ?? '0') }}">
    </div>

    <div class="col-md-2 mb-3">
        <label>Estoque Mínimo</label>
        <input type="number" name="estoque_minimo" class="form-control"
            value="{{ old('estoque_minimo', $produto->estoque_minimo ?? '0') }}">
    </div>

    <div class="col-md-2 mb-3">
        <label>Unidade</label>
        <select name="unidade_medida" class="form-select">
            <option value="Un" {{ old('unidade_medida', $produto->unidade_medida ?? '') == 'Un' ? 'selected' : '' }}>Unidade (Un)</option>
            <option value="Kg" {{ old('unidade_medida', $produto->unidade_medida ?? '') == 'Kg' ? 'selected' : '' }}>Quilo (Kg)</option>
            <option value="L" {{ old('unidade_medida', $produto->unidade_medida ?? '') == 'L' ? 'selected' : '' }}>Litro (L)</option>
            <option value="Cx" {{ old('unidade_medida', $produto->unidade_medida ?? '') == 'Cx' ? 'selected' : '' }}>Caixa (Cx)</option>
            <option value="Pct" {{ old('unidade_medida', $produto->unidade_medida ?? '') == 'Pct' ? 'selected' : '' }}>Pacote (Pct)</option>
        </select>
    </div>
    
    <div class="col-md-2 mb-3">
        <label>Validade (Dias)</label>
        <input type="number" name="validade_padrao_dias" class="form-control" placeholder="Opcional"
            value="{{ old('validade_padrao_dias', $produto->validade_padrao_dias ?? '') }}">
    </div>
</div>

<div class="form-check mb-3 mt-2">
    <input type="checkbox" name="ativo" class="form-check-input" id="ativo"
        {{ old('ativo', $produto->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="ativo">Produto Ativo</label>
</div>