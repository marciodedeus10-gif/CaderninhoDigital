@extends('layouts.app')

@section('content')

<div class="container">

<h2>Atualizar Cadastro</h2>

<form action="{{ route('perfil.update') }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Nome</label>
<input type="text" name="name" value="{{ $user->name }}" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="{{ $user->email }}" class="form-control">
</div>

<button class="btn btn-success">
Salvar Alterações
</button>

</form>

</div>

@endsection
