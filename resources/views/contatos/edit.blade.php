@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Editar Contato</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('contatos.update', $contato) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" 
                               value="{{ $contato->nome }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control" 
                               value="{{ $contato->telefone ?? '' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ $contato->email ?? '' }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observação</label>
                        <textarea name="observacao" class="form-control" rows="3">
{{ $contato->observacao ?? '' }}
                        </textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('contatos.index') }}" class="btn btn-secondary">
                        Voltar
                    </a>

                    <button type="submit" class="btn btn-success">
                        Atualizar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection