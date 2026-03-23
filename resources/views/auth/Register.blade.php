@extends('layouts.auth')

@section('title', 'Cadastro')

@section('content')

    <h4 class="text-center mb-4">Cadastro</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"
                required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Senha" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Já tem conta? Fazer login</a>
    </div>

@endsection
