@extends('layouts.app')

@section('content')

<h2>Editar Cliente</h2>

<form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
    @csrf
    @method('PUT')

    @include('clientes.form')

    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>

@endsection