<form action="{{ route('clientes.store') }}" method="POST">
    @csrf

    @include('clientes.form')

    <button type="submit" class="btn btn-primary">
        Salvar
    </button>
</form>
