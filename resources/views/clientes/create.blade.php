@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>Novo Cliente</h2>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <input type="text" name="nome" placeholder="Nome"><br><br>

            <input type="text" name="telefone" placeholder="Telefone"><br><br>

            <input type="email" name="email" placeholder="Email"><br><br>

            <input type="text" name="endereco" placeholder="Endereço"><br><br>

            <input type="text" name="bairro" placeholder="Bairro"><br><br>

            <input type="text" name="cidade" placeholder="Cidade"><br><br>

            <input type="text" name="estado" placeholder="Estado"><br><br>

            <input type="text" name="cpf_cnpj" placeholder="CPF ou CNPJ"><br><br>

            <textarea name="observacoes" placeholder="Observações"></textarea><br><br>

            <button type="submit">Salvar</button>

        </form>

    </div>
@endsection
