@extends('layouts.app')

@section('content')
    <h2>Venda #{{ $venda->id }}</h2>

    Status: {{ $venda->status }}

    <hr>

    <h4>Adicionar Produto</h4>

    <form method="POST" action="{{ route('vendas.addItem', $venda->id) }}">
        @csrf

        <select name="produto_id">
            <option value="">Selecione</option>

            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}">
                    {{ $produto->nome }}
                </option>
            @endforeach
        </select>

        <input type="number" name="quantidade" placeholder="Quantidade">

        <input type="text" name="preco" placeholder="Preço">

        <button class="btn btn-success">
            Adicionar
        </button>
    </form>

    <hr>

    <h4>Dados do Cliente</h4>

    <p><strong>Nome:</strong> {{ $venda->cliente->nome }}</p>
    <p><strong>Telefone:</strong> {{ $venda->cliente->telefone }}</p>
    <p><strong>Cidade:</strong> {{ $venda->cliente->cidade }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Desconto</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($venda->itens as $item)
                <tr>
                    <td>{{ $item->produto->nome }}</td>
                    <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>
                        R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                    </td>
                    <td>
                        R$ {{ number_format($item->desconto, 2, ',', '.') }}
                    </td>
                    <td>
                        R$ {{ number_format($item->preco * $item->quantidade - $item->desconto, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card">
        <div class="card-body">
            <p><strong>Desconto Total:</strong>
                R$ {{ number_format($descontoTotal, 2, ',', '.') }}
            </p>

            <h4>
                Total da Venda:
                R$ {{ number_format($total, 2, ',', '.') }}
            </h4>

        </div>
    </div>

    <!-- MODAL PRODUTO -->
<div class="modal fade" id="modalProduto">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Adicionar Produto</h5>
            </div>

            <form method="POST" action="{{ route('vendas.addItem', $venda->id) }}">
                @csrf

                <div class="modal-body">

                    <label>Pesquisar Produto</label>
                    <input type="text" id="buscarProduto" class="form-control mb-2" placeholder="Digite o nome">

                    <select name="produto_id" id="produtoSelect" class="form-control">
                        <option value="">Selecione</option>

                        @foreach ($produtos as $produto)
                            <option
                                value="{{ $produto->id }}"
                                data-preco="{{ $produto->preco_venda }}"
                            >
                                {{ $produto->nome }}
                            </option>
                        @endforeach
                    </select>

                    <br>

                    <label>Preço</label>
                    <input type="text" name="preco" id="precoProduto" class="form-control">

                    <br>

                    <label>Quantidade</label>
                    <input type="number" name="quantidade" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Adicionar Produto
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- MODAL SERVIÇO -->
<div class="modal fade" id="modalServico">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Adicionar Serviço</h5>
            </div>

            <form method="POST" action="{{ route('vendas.addServico', $venda->id) }}">
                @csrf

                <div class="modal-body">

                    <select name="servico_id" class="form-control">
                        <option value="">Selecione</option>

                        @foreach ($servicos as $servico)
                            <option
                                value="{{ $servico->id }}"
                                data-preco="{{ $servico->preco }}"
                            >
                                {{ $servico->nome }}
                            </option>
                        @endforeach
                    </select>

                    <br>

                    <label>Preço</label>
                    <input type="text" name="preco" id="precoServico" class="form-control">

                    <br>

                    <label>Quantidade</label>
                    <input type="number" name="quantidade" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Adicionar Serviço
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
