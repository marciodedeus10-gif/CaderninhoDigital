@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2>Editar Produto</h2>

    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf
        @method('PUT')

        @include('produtos.form')

        <button class="btn btn-primary">Atualizar</button>
    </form>
</div>

@endsection
