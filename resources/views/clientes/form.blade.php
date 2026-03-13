<div class="mb-3">
    <label>Nome *</label>
    <input type="text" name="nome" value="{{ old('nome', $cliente->nome ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label>Telefone *</label>
    <input type="text" name="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}" class="form-control"
        required>
</div>

<div class="mb-3">
    <label>Cidade</label>
    <input type="text" name="cidade" value="{{ old('cidade', $cliente->cidade ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Bairro</label>
    <input type="text" name="bairro" value="{{ old('bairro', $cliente->bairro ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Endereço</label>
    <input type="text" name="endereco" value="{{ old('endereco', $cliente->endereco ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Número</label>
    <input type="text" name="numero" value="{{ old('numero', $cliente->numero ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>CEP</label>
    <input type="text" name="cep" value="{{ old('cep', $cliente->cep ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Estado</label>
    <input type="text" name="estado" value="{{ old('estado', $cliente->estado ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="ativo" class="form-control">
        <option value="1" {{ old('ativo', $cliente->ativo ?? 1) == 1 ? 'selected' : '' }}>
            Ativo
        </option>
        <option value="0" {{ old('ativo', $cliente->ativo ?? '') == 0 ? 'selected' : '' }}>
            Inativo
        </option>
    </select>
</div>
