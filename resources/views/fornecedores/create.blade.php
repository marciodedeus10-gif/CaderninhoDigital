@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Novo Fornecedor</h2>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('fornecedores.store') }}" method="POST">
                @csrf
                @include('fornecedores.form')
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Salvar Fornecedor</button>
                    <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
