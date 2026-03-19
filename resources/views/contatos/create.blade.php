@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow-lg rounded-4">

                {{-- HEADER --}}
                <div class="card-header bg-success text-white rounded-top-4">
                    <h4 class="mb-0">
                        📩 Fale com a gente
                    </h4>
                    <small>Envie sua mensagem para nossa equipe</small>
                </div>

                {{-- BODY --}}
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contatos.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            {{-- NOME --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nome</label>
                                <input type="text" name="nome"
                                    class="form-control rounded-3 shadow-sm"
                                    placeholder="Digite seu nome" required>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                    class="form-control rounded-3 shadow-sm"
                                    placeholder="Digite seu email" required>
                            </div>

                            {{-- ASSUNTO --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Assunto</label>
                                <input type="text" name="assunto"
                                    class="form-control rounded-3 shadow-sm"
                                    placeholder="Ex: Dúvida, suporte, erro no sistema">
                            </div>

                            {{-- MENSAGEM --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Mensagem</label>
                                <textarea name="mensagem" rows="4"
                                    class="form-control rounded-3 shadow-sm"
                                    placeholder="Digite sua mensagem..." required></textarea>
                            </div>

                        </div>

                        {{-- BOTÕES --}}
                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{ route('contatos.index') }}"
                               class="btn btn-outline-secondary px-4 rounded-3">
                                ← Voltar
                            </a>

                            <button type="submit"
                                    class="btn btn-success px-4 rounded-3 shadow-sm">
                                Enviar 🚀
                            </button>

                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection