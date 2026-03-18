@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Novo Cliente</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Nome --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome"
                               class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}">

                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Telefone --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone"
                               class="form-control @error('telefone') is-invalid @enderror"
                               value="{{ old('telefone') }}">

                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CPF/CNPJ --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF / CNPJ</label>
                        <input type="text" name="cpf_cnpj"
                               class="form-control @error('cpf_cnpj') is-invalid @enderror"
                               value="{{ old('cpf_cnpj') }}">

                        @error('cpf_cnpj')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Endereço --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="endereco"
                               class="form-control @error('endereco') is-invalid @enderror"
                               value="{{ old('endereco') }}">

                        @error('endereco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Número --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Número</label>
                        <input type="text" name="numero"
                               class="form-control @error('numero') is-invalid @enderror"
                               value="{{ old('numero') }}">

                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CEP --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep"
                               class="form-control @error('cep') is-invalid @enderror"
                               value="{{ old('cep') }}">

                        @error('cep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bairro --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="bairro"
                               class="form-control @error('bairro') is-invalid @enderror"
                               value="{{ old('bairro') }}">

                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Cidade --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade"
                               class="form-control @error('cidade') is-invalid @enderror"
                               value="{{ old('cidade') }}">

                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-1 mb-3">
                        <label class="form-label">UF</label>
                        <input type="text" name="estado"
                               class="form-control @error('estado') is-invalid @enderror"
                               value="{{ old('estado') }}">
                    </div>

                    {{-- Observações --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observações</label>
                        <textarea name="observacoes"
                                  class="form-control @error('observacoes') is-invalid @enderror"
                                  rows="3">{{ old('observacoes') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        💾 Salvar Cliente
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
