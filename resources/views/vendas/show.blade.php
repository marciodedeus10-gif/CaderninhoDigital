@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- HEADER --}}
        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">Venda #{{ $venda->id }}</h4>
                    <div class="text-muted mt-2" style="font-size: 0.9rem;">
                        <div class="mb-1">
                            <i class="bi bi-person"></i> Cliente: <strong class="text-dark">{{ $venda->cliente->nome }}</strong>
                        </div>
                        <div class="mb-1">
                            <i class="bi bi-telephone"></i> Telefone: <span class="text-dark">{{ $venda->cliente->telefone ?? 'Não informado' }}</span>
                        </div>
                        <div>
                            <i class="bi bi-calendar-event"></i> Data da Venda: <span class="text-dark">{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">

                    @php
                        $statusClass = match(strtolower($venda->status)) {
                            'pago', 'finalizada', 'concluída' => 'bg-success',
                            'aberta', 'pendente', 'aguardando' => 'bg-warning text-dark',
                            'cancelada' => 'bg-danger',
                            default => 'bg-warning text-dark'
                        };
                    @endphp
                    <span class="badge {{ $statusClass }} fs-6">
                        {{ ucfirst($venda->status) }}
                    </span>

                    @if ($venda->status == 'aberta')
                        <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir toda esta venda? Esta ação não pode ser desfeita.');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> Excluir Venda
                            </button>
                        </form>

                        <form action="{{ route('vendas.finalizar', $venda->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">
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
                                <td>{{ $item->produto->nome ?? 'Produto removido' }}</td>
                                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>
                                    R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                                </td>

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
                                <td>{{ $item->servico->nome ?? 'Serviço removido' }}</td>
                                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>
                                    R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                                </td>

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
                                <td colspan="6">Nenhum serviço adicionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TOTAL --}}
        <div class="card shadow mb-4">
            <div class="card-body">
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row justify-content-end">
                    <div class="col-md-5 col-lg-4">
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fs-5 text-muted">Subtotal:</span>
                            <span class="fs-5 fw-bold text-dark">R$ {{ number_format($venda->subtotal, 2, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="fs-6 text-muted">Desconto:</span>
                            <div class="d-flex align-items-center gap-2">
                                @if(($venda->desconto ?? 0) > 0 && $venda->status == 'aberta')
                                    <form action="{{ route('vendas.updateDesconto', $venda->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <input type="hidden" name="desconto" value="0">
                                        <input type="hidden" name="tipo_desconto" value="valor">
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" title="Remover Desconto">
                                            <i class="bi bi-x-circle-fill"></i> Limpar
                                        </button>
                                    </form>
                                @endif
                                <span class="fs-6 text-danger fw-bold">- R$ {{ number_format($venda->desconto ?? 0, 2, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-3 fw-bold">Total:</span>
                            <span class="fs-3 fw-bold text-success">R$ {{ number_format($venda->total, 2, ',', '.') }}</span>
                        </div>

                        @if ($venda->status == 'aberta')
                        <form action="{{ route('vendas.updateDesconto', $venda->id) }}" method="POST" class="bg-light p-3 rounded border">
                            @csrf
                            <label class="form-label fw-bold small text-muted mb-2">Aplicar Desconto</label>
                            <div class="input-group">
                                <select name="tipo_desconto" class="form-select bg-white" style="max-width: 90px;">
                                    <option value="valor">R$</option>
                                    <option value="porcentagem">%</option>
                                </select>
                                <input type="number" step="0.01" name="desconto" class="form-control" placeholder="0.00" min="0" required>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="bi bi-check-lg"></i> Aplicar
                                </button>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
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

                        @if(isset($produtosMaisVendidos) && $produtosMaisVendidos->count() > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold mb-2">Mais Vendidos</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($produtosMaisVendidos as $pMaisVendido)
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-mais-vendido"
                                                data-id="{{ $pMaisVendido->id }}"
                                                data-preco="{{ $pMaisVendido->preco }}">
                                            {{ $pMaisVendido->nome }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Produto</label>
                            <select name="produto_id" id="produtoSelect"
                                class="form-select @error('produto_id') is-invalid @enderror" required>
                                <option value="">Selecione</option>

                                @foreach ($produtos as $produto)
                                    <option value="{{ $produto->id }}" data-preco="{{ $produto->preco }}">
                                        {{ $produto->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço Unitário</label>
                            <input type="text" name="preco" id="precoProduto" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" id="btnMinusQty">-</button>
                                <input type="number" name="quantidade" id="inputQty" class="form-control text-center" value="1" min="1" required>
                                <button class="btn btn-outline-secondary" type="button" id="btnPlusQty">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success fw-bold">Valor Total</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white">R$</span>
                                <input type="text" id="valorTotalInput" class="form-control fw-bold text-success bg-light" readonly value="0,00">
                            </div>
                        </div>

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

                        @if(isset($servicosMaisVendidos) && $servicosMaisVendidos->count() > 0)
                            <div class="mb-3">
                                <label class="form-label fw-bold mb-2">Mais Vendidos</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($servicosMaisVendidos as $sMaisVendido)
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-servico-mais-vendido"
                                                data-id="{{ $sMaisVendido->id }}"
                                                data-preco="{{ $sMaisVendido->preco }}">
                                            {{ $sMaisVendido->nome }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Serviço</label>
                            <select name="servico_id" id="servicoSelect"
                                class="form-select @error('servico_id') is-invalid @enderror" required>
                                <option value="">Selecione</option>

                                @foreach ($servicos as $servico)
                                    <option value="{{ $servico->id }}" data-preco="{{ $servico->preco }}">
                                        {{ $servico->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço Unitário</label>
                            <input type="text" name="preco" id="precoServico" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" id="btnMinusQtyServico">-</button>
                                <input type="number" name="quantidade" id="inputQtyServico" class="form-control text-center" value="1" min="1" required>
                                <button class="btn btn-outline-secondary" type="button" id="btnPlusQtyServico">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success fw-bold">Valor Total</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white">R$</span>
                                <input type="text" id="valorTotalInputServico" class="form-control fw-bold text-success bg-light" readonly value="0,00">
                            </div>
                        </div>

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
            const inputQty = document.getElementById('inputQty');
            const btnMinusQty = document.getElementById('btnMinusQty');
            const btnPlusQty = document.getElementById('btnPlusQty');
            const valorTotalInput = document.getElementById('valorTotalInput');
            const btnsMaisVendidos = document.querySelectorAll('.btn-mais-vendido');

            function atualizarTotalDynamic() {
                if (!precoProduto || !inputQty || !valorTotalInput) return;
                let preco = parseFloat(precoProduto.value.replace(',', '.')) || 0;
                let qtd = parseInt(inputQty.value) || 1;
                let total = preco * qtd;
                valorTotalInput.value = total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            if (produtoSelect) {
                produtoSelect.addEventListener('change', function() {
                    let preco = this.options[this.selectedIndex]?.getAttribute('data-preco');
                    if (preco) {
                        precoProduto.value = parseFloat(preco).toFixed(2).replace('.', ',');
                    } else {
                        precoProduto.value = '';
                    }
                    atualizarTotalDynamic();
                });
            }

            if (precoProduto) {
                precoProduto.addEventListener('input', atualizarTotalDynamic);
            }

            if (inputQty) {
                inputQty.addEventListener('input', atualizarTotalDynamic);
                
                if (btnMinusQty) {
                    btnMinusQty.addEventListener('click', function() {
                        let currentVal = parseInt(inputQty.value) || 1;
                        if (currentVal > 1) {
                            inputQty.value = currentVal - 1;
                            atualizarTotalDynamic();
                        }
                    });
                }
                
                if (btnPlusQty) {
                    btnPlusQty.addEventListener('click', function() {
                        let currentVal = parseInt(inputQty.value) || 1;
                        inputQty.value = currentVal + 1;
                        atualizarTotalDynamic();
                    });
                }
            }

            if (btnsMaisVendidos.length > 0) {
                btnsMaisVendidos.forEach(btn => {
                    btn.addEventListener('click', function() {
                        let id = this.getAttribute('data-id');
                        let preco = this.getAttribute('data-preco');
                        
                        produtoSelect.value = id;
                        precoProduto.value = parseFloat(preco).toFixed(2).replace('.', ',');
                        
                        inputQty.value = 1;
                        
                        atualizarTotalDynamic();
                    });
                });
            }

            const servicoSelect = document.getElementById('servicoSelect');
            const precoServico = document.getElementById('precoServico');
            const inputQtyServico = document.getElementById('inputQtyServico');
            const btnMinusQtyServico = document.getElementById('btnMinusQtyServico');
            const btnPlusQtyServico = document.getElementById('btnPlusQtyServico');
            const valorTotalInputServico = document.getElementById('valorTotalInputServico');
            const btnsServicosMaisVendidos = document.querySelectorAll('.btn-servico-mais-vendido');

            function atualizarTotalServico() {
                if (!precoServico || !inputQtyServico || !valorTotalInputServico) return;
                let preco = parseFloat(precoServico.value.replace(',', '.')) || 0;
                let qtd = parseInt(inputQtyServico.value) || 1;
                let total = preco * qtd;
                valorTotalInputServico.value = total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            if (servicoSelect) {
                servicoSelect.addEventListener('change', function() {
                    let preco = this.options[this.selectedIndex]?.getAttribute('data-preco');
                    if (preco) {
                        precoServico.value = parseFloat(preco).toFixed(2).replace('.', ',');
                    } else {
                        precoServico.value = '';
                    }
                    atualizarTotalServico();
                });
            }

            if (precoServico) {
                precoServico.addEventListener('input', atualizarTotalServico);
            }

            if (inputQtyServico) {
                inputQtyServico.addEventListener('input', atualizarTotalServico);
                
                if (btnMinusQtyServico) {
                    btnMinusQtyServico.addEventListener('click', function() {
                        let currentVal = parseInt(inputQtyServico.value) || 1;
                        if (currentVal > 1) {
                            inputQtyServico.value = currentVal - 1;
                            atualizarTotalServico();
                        }
                    });
                }
                
                if (btnPlusQtyServico) {
                    btnPlusQtyServico.addEventListener('click', function() {
                        let currentVal = parseInt(inputQtyServico.value) || 1;
                        inputQtyServico.value = currentVal + 1;
                        atualizarTotalServico();
                    });
                }
            }

            if (btnsServicosMaisVendidos.length > 0) {
                btnsServicosMaisVendidos.forEach(btn => {
                    btn.addEventListener('click', function() {
                        let id = this.getAttribute('data-id');
                        let preco = this.getAttribute('data-preco');
                        
                        servicoSelect.value = id;
                        precoServico.value = parseFloat(preco).toFixed(2).replace('.', ',');
                        
                        inputQtyServico.value = 1;
                        
                        atualizarTotalServico();
                    });
                });
            }

        });
    </script>
@endsection
