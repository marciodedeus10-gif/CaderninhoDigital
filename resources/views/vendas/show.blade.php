@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- HEADER --}}
        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">Venda #{{ $venda->id }}</h4>
                    <small class="text-muted">
                        Cliente: {{ $venda->cliente->nome }}
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2">

                    <span class="badge bg-success">
                        {{ ucfirst($venda->status) }}
                    </span>

                    @if ($venda->status == 'aberta')
                        <form action="{{ route('vendas.finalizar', $venda->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button class="btn btn-success btn-sm">
                                ✔ Finalizar
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        </div>

        {{-- PRODUTOS --}}
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between">
                <strong>Produtos</strong>

                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduto">
                    ➕ Produto
                </button>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($venda->itens->whereNotNull('produto_id') as $item)
                            <tr>
                                <td>{{ $item->produto->nome }}</td>
                                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>
                                    R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                                </td>
                                ===
                                <td class="fw-bold">
                                    R$
                                    {{ number_format($item->preco * $item->quantidade - ($item->desconto ?? 0), 2, ',', '.') }}
                                </td>
                                <td>
                                    <form action="{{ route('vendas.removeItem', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Nenhum produto adicionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- SERVIÇOS --}}
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between">
                <strong>Serviços</strong>

                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalServico">
                    ➕ Serviço
                </button>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Serviço</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Exluir</th>
                        </tr>
                    </thead>



                    <tbody>
                        @forelse ($venda->itens->whereNotNull('servico_id') as $item)
                            <tr>
                                <td>{{ $item->servico->nome }}</td>
                                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>
                                    R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                                </td>

                                <td class="fw-bold">
                                    R$
                                    {{ number_format($item->preco * $item->quantidade - $item->desconto, 2, ',', '.') }}
                                </td>
                                <td>
                                    <form action="{{ route('vendas.removeItem', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Nenhum serviço adicionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TOTAL --}}
        <div class="card shadow">
            <div class="card-body text-end">
                <form action="{{ route('vendas.updateDesconto', $venda->id) }}" method="POST"
                    class="d-flex justify-content-end align-items-center gap-2 mb-2">

                    @csrf

                    <label class="mb-0"><strong>Desconto Total:</strong></label>

                    <input type="number" step="0.01" name="desconto_total" value="{{ $venda->desconto_total ?? 0 }}"
                        class="form-control form-control-sm" style="width: 120px;">

                    <button type="submit" class="btn btn-success btn-sm">
                        ✔
                    </button>
                </form>

                <h3 class="text-success">
                    Total: R$
                    {{ number_format(($total ?? 0) - ($venda->desconto_total ?? 0), 2, ',', '.') }}
                </h3>
            </div>
        </div>

    </div>

    {{-- MODAL PRODUTO --}}
    <div class="modal fade" id="modalProduto">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('vendas.addItem', $venda->id) }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <label>Produto</label>
                        <select name="produto_id" id="produtoSelect"
                            class="form-control @error('produto_id') is-invalid @enderror">
                            <option value="">Selecione</option>

                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}">
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>

                        <br>

                        <label>Preço</label>
                        <input type="text" name="preco" id="precoProduto" class="form-control">

                        <br>

                        <label>Quantidade</label>
                        <input type="number" name="quantidade" class="form-control" value="1">

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success w-100">
                            Adicionar Produto
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- MODAL SERVIÇO --}}
    <div class="modal fade" id="modalServico">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('vendas.addServico', $venda->id) }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <label>Serviço</label>
                        <select name="servico_id" id="servicoSelect"
                            class="form-control @error('servico_id') is-invalid @enderror">
                            <option value="">Selecione</option>

                            @foreach ($servicos as $servico)
                                <option value="{{ $servico->id }}" data-preco="{{ $servico->preco }}">
                                    {{ $servico->nome }}
                                </option>
                            @endforeach
                        </select>

                        <br>

                        <label>Preço</label>
                        <input type="text" name="preco" id="precoServico" class="form-control">

                        <br>

                        <label>Quantidade</label>
                        <input type="number" name="quantidade" class="form-control" value="1">

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success w-100">
                            Adicionar Serviço
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const produtoSelect = document.getElementById('produtoSelect');
            const precoProduto = document.getElementById('precoProduto');

            if (produtoSelect) {
                produtoSelect.addEventListener('change', function() {
                    let preco = this.options[this.selectedIndex].getAttribute('data-preco');
                    precoProduto.value = preco ? preco : '';
                });
            }

            const servicoSelect = document.getElementById('servicoSelect');
            const precoServico = document.getElementById('precoServico');

            if (servicoSelect) {
                servicoSelect.addEventListener('change', function() {
                    let preco = this.options[this.selectedIndex].getAttribute('data-preco');
                    precoServico.value = preco ? preco : '';
                });
            }

        });
    </script>
@endsection
