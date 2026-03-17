<form method="POST" action="{{ route('vendas.store') }}">
    @csrf

    <label>Cliente</label>
    <select name="cliente_id" required>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
        @endforeach
    </select>

    <hr>

    <h4>Produtos</h4>

    <div id="produtos">
        <div class="item">
            <select name="produtos[]">
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">
                        {{ $produto->nome }} - R$ {{ $produto->preco }}
                    </option>
                @endforeach
            </select>

            <input type="number" name="quantidades[]" placeholder="Qtd">
        </div>
    </div>

    <button type="button" onclick="addProduto()">+ Adicionar Produto</button>

    <hr>

    <label>Data Venda</label>
    <input type="date" name="data_venda">

    <label>Data Vencimento</label>
    <input type="date" name="data_vencimento">

    <textarea name="observacoes" placeholder="Observações"></textarea>

    <button type="submit">Salvar</button>
</form>

<script>
function addProduto() {
    let div = document.createElement('div');
    div.innerHTML = `
        <select name="produtos[]">
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}">
                    {{ $produto->nome }} - R$ {{ $produto->preco }}
                </option>
            @endforeach
        </select>

        <input type="number" name="quantidades[]" placeholder="Qtd">
    `;
    document.getElementById('produtos').appendChild(div);
}
</script>