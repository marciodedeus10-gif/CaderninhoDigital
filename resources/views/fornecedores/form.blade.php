<div class="row">
    <div class="col-md-6 mb-3">
        <label>Nome / Razão Social *</label>
        <input type="text" name="nome" class="form-control" value="{{ old('nome', $forn->nome ?? '') }}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label>CNPJ / CPF</label>
        <input type="text" name="cnpj_cpf" id="cnpj_cpf" class="form-control" value="{{ old('cnpj_cpf', $forn->cnpj_cpf ?? '') }}" placeholder="000.000.000-00 ou 00.000.000/0000-00">
    </div>
    <div class="col-md-3 mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone', $forn->telefone ?? '') }}" placeholder="(00) 00000-0000">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $forn->email ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label>Endereço Completo</label>
        <input type="text" name="endereco" class="form-control" value="{{ old('endereco', $forn->endereco ?? '') }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>CEP</label>
        <input type="text" name="cep" id="cep" class="form-control" value="{{ old('cep', $forn->cep ?? '') }}" placeholder="00000-000">
    </div>
    <div class="col-md-4 mb-3">
        <label>Data de Cadastro</label>
        <input type="text" name="data_cadastro" id="data_cadastro" class="form-control" value="{{ old('data_cadastro', $forn->data_cadastro ?? now()->format('d/m/Y')) }}" placeholder="dd/mm/aaaa">
    </div>
    <div class="col-md-4 mb-3">
        <label>Valor Mínimo de Compra</label>
        <input type="text" name="valor_minimo" id="valor_minimo" class="form-control" value="{{ old('valor_minimo', $forn->valor_minimo ?? '') }}" placeholder="0,00">
    </div>
</div>

<div class="mb-3">
    <label>Observações</label>
    <textarea name="observacoes" class="form-control" rows="2">{{ old('observacoes', $forn->observacoes ?? '') }}</textarea>
</div>

<div class="form-check mb-3 mt-2">
    <input type="checkbox" name="ativo" class="form-check-input" id="ativo"
        {{ old('ativo', $forn->ativo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="ativo">Fornecedor Ativo</label>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- MÁSCARA TELEFONE ---
        const telInput = document.getElementById('telefone');
        if (telInput) {
            telInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 11) v = v.substring(0, 11);

                let x = v.match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                if (!x[2]) {
                    e.target.value = x[1];
                } else if (!x[3]) {
                    e.target.value = `(${x[1]}) ${x[2]}`;
                } else {
                    e.target.value = `(${x[1]}) ${x[2]}-${x[3]}`;
                }
            });
        }

        // --- MÁSCARA CPF/CNPJ ---
        const cpfCnpjInput = document.getElementById('cnpj_cpf');
        if (cpfCnpjInput) {
            cpfCnpjInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, "");
                if (v.length > 14) v = v.substring(0, 14);

                if (v.length <= 11) {
                    // CPF
                    v = v.replace(/(\d{3})(\d)/, "$1.$2");
                    v = v.replace(/(\d{3})(\d)/, "$1.$2");
                    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
                } else {
                    // CNPJ
                    v = v.replace(/^(\d{2})(\d)/, "$1.$2");
                    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
                    v = v.replace(/(\d{4})(\d)/, "$1-$2");
                }
                e.target.value = v;
            });
        }

        // --- MÁSCARA CEP ---
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 8) v = v.substring(0, 8);
                v = v.replace(/(\d{5})(\d)/, '$1-$2');
                e.target.value = v;
            });
        }

        // --- MÁSCARA DATA ---
        const dataInput = document.getElementById('data_cadastro');
        if (dataInput) {
            dataInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 8) v = v.substring(0, 8);
                v = v.replace(/(\d{2})(\d)/, '$1/$2');
                v = v.replace(/(\d{2})(\d)/, '$1/$2');
                e.target.value = v;
            });
        }

        // --- MÁSCARA VALOR MONETÁRIO ---
        const valorInput = document.getElementById('valor_minimo');
        if (valorInput) {
            valorInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, '');
                v = (v / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+,)/g, '$1.');
                e.target.value = v;
            });
        }
    });
</script>
