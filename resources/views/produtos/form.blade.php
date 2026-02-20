<div class="mb-3">
    <label>Nome</label>
    <input type="text" name="nome" class="form-control"
        value="{{ old('nome', $produto->nome ?? '') }}">
</div>

<div class="mb-3">
    <label>Descrição</label>
    <textarea name="descricao" class="form-control">
        {{ old('descricao', $produto->descricao ?? '') }}
    </textarea>
</div>

<div class="mb-3">
    <label>Preço</label>
    <input type="number" step="0.01" name="preco" class="form-control"
        value="{{ old('preco', $produto->preco ?? '') }}">
</div>

<div class="mb-3">
    <label>Categoria</label>
    <input type="text" name="categoria" class="form-control"
        value="{{ old('categoria', $produto->categoria ?? '') }}">
</div>

<div class="mb-3">
    <label>Validade Padrão (dias)</label>
    <input type="number" name="validade_padrao_dias" class="form-control"
        value="{{ old('validade_padrao_dias', $produto->validade_padrao_dias ?? '') }}">
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="recorrente" class="form-check-input"
        {{ old('recorrente', $produto->recorrente ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Produto Recorrente</label>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="ativo" class="form-check-input"
        {{ old('ativo', $produto->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Ativo</label>
</div>
