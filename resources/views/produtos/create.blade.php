@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2>Novo Produto</h2>

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf

        @include('produtos.form')

        <button class="btn btn-success">Salvar</button>
    </form>
</div>

@endsection
