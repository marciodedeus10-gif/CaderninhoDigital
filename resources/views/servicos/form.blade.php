<div class="mb-3">
    <label>Nome</label>
    <input type="text" name="nome"
        value="{{ old('nome', $servico->nome ?? '') }}"
        class="form-control" required>
</div>

<div class="mb-3">
    <label>Descrição</label>
    <textarea name="descricao" class="form-control">
        {{ old('descricao', $servico->descricao ?? '') }}
    </textarea>
</div>

<div class="mb-3">
    <label>Preço</label>
    <input type="number" step="0.01" name="preco"
        value="{{ old('preco', $servico->preco ?? '') }}"
        class="form-control" required>
</div>

<div class="mb-3">
    <label>Categoria</label>
    <input type="text" name="categoria"
        value="{{ old('categoria', $servico->categoria ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Validade (dias)</label>
    <input type="number" name="validade_padrao_dias"
        value="{{ old('validade_dias', $servico->validade_dias ?? '') }}"
        class="form-control">
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="ativo"
        class="form-check-input"
        value="1"
        {{ old('ativo', $servico->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Ativo</label>
</div>

<button type="submit" class="btn btn-success">
    Salvar
</button>