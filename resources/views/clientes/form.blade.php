<div class="row">
    <input type="hidden" name="origin" value="{{ request('origin') }}">


    {{-- Nome --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="nome" value="{{ old('nome', $cliente->nome ?? '') }}"
               class="form-control @error('nome') is-invalid @enderror" required>
        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Telefone --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Telefone *</label>
        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}"
               class="form-control @error('telefone') is-invalid @enderror" required placeholder="(00) 00000-0000">
        @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Email --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $cliente->email ?? '') }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- CPF/CNPJ --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">CPF / CNPJ</label>
        <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="{{ old('cpf_cnpj', $cliente->cpf_cnpj ?? '') }}"
               class="form-control @error('cpf_cnpj') is-invalid @enderror" placeholder="000.000.000-00">
        @error('cpf_cnpj') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- CEP --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">CEP</label>
        <input type="text" name="cep" id="cep" value="{{ old('cep', $cliente->cep ?? '') }}"
               class="form-control @error('cep') is-invalid @enderror" placeholder="00000-000">
        @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Endereço --}}
    <div class="col-md-8 mb-3">
        <label class="form-label">Endereço</label>
        <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $cliente->endereco ?? '') }}"
               class="form-control @error('endereco') is-invalid @enderror">
        @error('endereco') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Número --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Número</label>
        <input type="text" name="numero" id="numero" value="{{ old('numero', $cliente->numero ?? '') }}"
               class="form-control @error('numero') is-invalid @enderror">
        @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Bairro --}}
    <div class="col-md-5 mb-3">
        <label class="form-label">Bairro</label>
        <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $cliente->bairro ?? '') }}"
               class="form-control @error('bairro') is-invalid @enderror">
        @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Cidade --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Cidade</label>
        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $cliente->cidade ?? '') }}"
               class="form-control @error('cidade') is-invalid @enderror">
        @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Estado --}}
    <div class="col-md-1 mb-3">
        <label class="form-label">UF</label>
        <input type="text" name="estado" id="estado" value="{{ old('estado', $cliente->estado ?? '') }}"
               class="form-control @error('estado') is-invalid @enderror">
    </div>

    {{-- Status --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">Status</label>
        <select name="ativo" class="form-select">
            <option value="1" {{ old('ativo', $cliente->ativo ?? 1) == 1 ? 'selected' : '' }}>Ativo</option>
            <option value="0" {{ old('ativo', $cliente->ativo ?? '') == 0 ? 'selected' : '' }}>Inativo</option>
        </select>
    </div>

    {{-- Observações --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">Observações</label>
        <textarea name="observacoes" id="observacoes" class="form-control @error('observacoes') is-invalid @enderror"
                  rows="3">{{ old('observacoes', $cliente->observacoes ?? '') }}</textarea>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- BUSCA CEP ---
        const cepInput = document.getElementById('cep');
        const enderecoInput = document.getElementById('endereco');
        const bairroInput = document.getElementById('bairro');
        const cidadeInput = document.getElementById('cidade');
        const estadoInput = document.getElementById('estado');

        if (cepInput && !cepInput.dataset.listener) {
            cepInput.dataset.listener = 'true';
            
            cepInput.addEventListener('blur', function() {
                let cep = this.value.replace(/\D/g, '');
                
                if (cep.length === 8) {
                    cepInput.classList.remove('is-valid', 'is-invalid');
                    
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                cepInput.classList.add('is-valid');
                                if (enderecoInput) enderecoInput.value = data.logradouro;
                                if (bairroInput) bairroInput.value = data.bairro;
                                if (cidadeInput) cidadeInput.value = data.localidade;
                                if (estadoInput) estadoInput.value = data.uf;
                                if (document.getElementById('numero')) document.getElementById('numero').focus();
                            } else {
                                cepInput.classList.add('is-invalid');
                            }
                        })
                        .catch(error => console.error('Erro ao buscar CEP:', error));
                }
            });

            // Máscara CEP
            cepInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,5})(\d{0,3})/);
                e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2];
            });
        }

        // --- MÁSCARA TELEFONE ---
        const telInput = document.getElementById('telefone');
        if (telInput) {
            telInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
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
        const cpfCnpjInput = document.getElementById('cpf_cnpj');
        if (cpfCnpjInput) {
            cpfCnpjInput.addEventListener('input', function(e) {
                let v = e.target.value.replace(/\D/g, "");
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
    });
</script>

