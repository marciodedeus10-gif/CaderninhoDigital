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

                <span class="badge bg-success">
                    {{ ucfirst($venda->status) }}
                </span>
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
                            <th>Ações</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Subtotal</th>
                            <th>Desc.</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($venda->itens->whereNotNull('produto_id') as $item)
                            <tr>

                                {{-- AÇÕES --}}
                                <td>
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        🗑
                                    </button>
                                    </form>
                                </td>

                                {{-- PRODUTO --}}
                                <td>{{ $item->produto->nome }}</td>

                                <p class="mb-1">
                                    <strong>Desconto Total:</strong>
                                    <span class="text-danger">R$ 0,00</span>
                                </p>

                                <h3 class="text-success">
                                    Total: R$ <span id="total-geral">0.00</span>
                                </h3>

                                {{-- DESCONTO --}}
                                <td>
                                    <input type="number" class="form-control desconto" value="0" step="0.01">
                                </td>

                                {{-- TOTAL --}}
                                <td class="total-item">
                                    {{ $item->preco * $item->quantidade }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Nenhum produto adicionado</td>
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
                            <th>Desc.</th>
                            <th>Total</th>
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
                                <td class="text-danger">
                                    - R$ {{ number_format($item->desconto, 2, ',', '.') }}
                                </td>
                                <td class="fw-bold">
                                    R$
                                    {{ number_format($item->preco * $item->quantidade - $item->desconto, 2, ',', '.') }}
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
                <p class="mb-1">
                    <strong>Desconto Total:</strong>
                    <span class="text-danger">
                        <td>
                            <input type="number" step="0.01" class="form-control desconto" value="0">
                            <input class="preco">
                            <input class="qtd">
                        <td class="subtotal"></td>
                        </td>
                    </span>
                </p>

                <h3 class="text-success">
                    Total: R$ {{ number_format($total, 2, ',', '.') }}
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
                        <td>
                            <label>Preço</label>
                            <input type="number" name="preco" id="precoProduto" class="form-control">

                            <br>

                            <label>Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" value="1">
                        </td>

                        <td class="subtotal">
                            0
                        </td>
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
                        <input type="number" name="preco" id="precoProduto" class="form-control">

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
    <h3>Total: R$ <span id="total-geral">0.00</span></h3>

    {{-- SCRIPT --}}
    <script>
        function calcularTotal() {
            let total = 0;

            document.querySelectorAll('tbody tr').forEach(function(row) {

                let preco = parseFloat(row.querySelector('.preco')?.value) || 0;
                let qtd = parseFloat(row.querySelector('.qtd')?.value) || 0;
                let desconto = parseFloat(row.querySelector('.desconto')?.value) || 0;

                let subtotal = preco * qtd;
                let totalItem = subtotal - desconto;

                if (row.querySelector('.subtotal')) {
                    row.querySelector('.subtotal').innerText = subtotal.toFixed(2);
                }

                if (row.querySelector('.total-item')) {
                    row.querySelector('.total-item').innerText = totalItem.toFixed(2);
                }

                total += totalItem;
            });

            document.getElementById('total-geral').innerText = total.toFixed(2);
        }

        // recalcula ao digitar
        document.addEventListener('input', function(e) {
            if (
                e.target.classList.contains('qtd') ||
                e.target.classList.contains('desconto') ||
                e.target.classList.contains('preco')
            ) {
                calcularTotal();
            }
        });

        // calcula ao carregar
        window.onload = calcularTotal;
    </script>
@endsection
