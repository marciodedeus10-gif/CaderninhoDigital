<div class="mb-3">
    <label>Nome *</label>
    <input type="text" name="nome"
        value="{{ old('nome', $cliente->nome ?? '') }}"
        class="form-control" required>
</div>

<div class="mb-3">
    <label>Telefone *</label>
    <input type="text" name="telefone"
        value="{{ old('telefone', $cliente->telefone ?? '') }}"
        class="form-control" required>
</div>

<div class="mb-3">
    <label>Telefone *</label>
    <input type="text" name="telefone"
        value="{{ old('telefone', $cliente->telefone ?? '') }}"
        class="form-control" required>
</div>



<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email"
        value="{{ old('email', $cliente->email ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>CPF</label>
    <input type="text" name="cpf"
        value="{{ old('cpf', $cliente->cpf ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Data de Nascimento</label>
    <input type="date" name="data_nascimento"
        value="{{ old('data_nascimento', $cliente->data_nascimento ?? '') }}"
        class="form-control">
</div>

<hr>

<h5>Informações Estratégicas</h5>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="ativo"
            {{ old('status', $cliente->status ?? '') == 'ativo' ? 'selected' : '' }}>
            Ativo
        </option>
        <option value="inativo"
            {{ old('status', $cliente->status ?? '') == 'inativo' ? 'selected' : '' }}>
            Inativo
        </option>
        <option value="prospect"
            {{ old('status', $cliente->status ?? '') == 'prospect' ? 'selected' : '' }}>
            Prospect
        </option>
    </select>
</div>

<div class="mb-3">
    <label>Classificação</label>
    <select name="classificacao" class="form-control">
        <option value="bronze"
            {{ old('classificacao', $cliente->classificacao ?? '') == 'bronze' ? 'selected' : '' }}>
            Bronze
        </option>
        <option value="prata"
            {{ old('classificacao', $cliente->classificacao ?? '') == 'prata' ? 'selected' : '' }}>
            Prata
        </option>
        <option value="ouro"
            {{ old('classificacao', $cliente->classificacao ?? '') == 'ouro' ? 'selected' : '' }}>
            Ouro
        </option>
    </select>
</div>

<div class="mb-3">
    <label>Data do Último Contato</label>
    <input type="date" name="data_ultimo_contato"
        value="{{ old('data_ultimo_contato', $cliente->data_ultimo_contato ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Origem do Cliente</label>
    <input type="text" name="origem_cliente"
        value="{{ old('origem_cliente', $cliente->origem_cliente ?? '') }}"
        class="form-control"
        placeholder="Ex: Instagram, Indicação, WhatsApp">
</div>

<div class="mb-3">
    <label>Observação</label>
    <textarea name="observacao" class="form-control">{{ old('observacao', $cliente->observacao ?? '') }}</textarea>
</div>
--------


