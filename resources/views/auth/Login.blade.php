@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <h4 class="text-center mb-4">Login</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('password.request') }}">Esqueci minha senha</a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('register') }}">Não tem conta? Cadastre-se</a>
    </div>

@endsection
