@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Serviço</h2>

    <form action="{{ route('servicos.update', $servico) }}" method="POST">
        @csrf
        @method('PUT')

        @include('servicos.form')

    </form>
</div>
@endsection