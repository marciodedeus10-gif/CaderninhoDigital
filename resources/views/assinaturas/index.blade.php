@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Minha Assinatura</h1>
        <form action="{{ route('assinaturas.gratis') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                Obter assinatura Bronze grátis
            </button>
        </form>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($assinatura && $assinatura->estaAtiva())
            <!-- Assinatura Ativa -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Plano {{ $assinatura->plano->nome }}</h2>
                        <p class="text-gray-600">{{ $assinatura->plano->descricao }}</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        Ativa
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Valor</h3>
                        <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($assinatura->valor, 2, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">{{ ucfirst($assinatura->periodicidade) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Próxima Renovação</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $assinatura->data_renovacao->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-600">{{ $assinatura->diasParaExpirar() }} dias restantes</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Usuários</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $assinatura->plano->max_usuarios ?: 'Ilimitado' }}</p>
                        <p class="text-sm text-gray-600">máximo</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <form action="{{ route('assinaturas.cancelar') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200"
                                onclick="return confirm('Tem certeza que deseja cancelar sua assinatura?')">
                            Cancelar Assinatura
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong>Assinatura expirada ou inexistente</strong>
                <p>Renove sua assinatura para continuar usando o sistema</p>
            </div>
        @endif

        <!-- Planos Disponíveis -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Planos Disponíveis</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($planos as $plano)
                    <div class="bg-white rounded-lg shadow-md p-6 border-2 {{ $assinatura && $assinatura->plano_id == $plano->id ? 'border-blue-500' : 'border-gray-200' }}">
                        <div class="text-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $plano->nome }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $plano->descricao }}</p>
                        </div>

                        <div class="text-center mb-6">
                            <div class="text-3xl font-bold text-gray-900">
                                R$ {{ number_format($plano->preco_mensal, 2, ',', '.') }}
                                <span class="text-lg font-normal text-gray-600">/mês</span>
                            </div>
                            @if($plano->preco_anual)
                                <div class="text-sm text-gray-600 mt-1">
                                    ou R$ {{ number_format($plano->preco_anual, 2, ',', '.') }}/ano
                                </div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <div class="text-sm text-gray-600 mb-2">Recursos incluídos:</div>
                            <ul class="text-sm space-y-1">
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Até {{ $plano->max_usuarios ?: 'ilimitados' }} usuários
                                </li>
                                @foreach($plano->recursos as $recurso)
                                    <li class="flex items-center">
                                        <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ ucfirst(str_replace('_', ' ', $recurso)) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if(!$assinatura || $assinatura->plano_id != $plano->id)
    @if($plano->nome == 'Bronze')
        <form action="{{ route('assinaturas.gratis') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                Assinar grátis
            </button>
        </form>
    @else
        <form action="{{ route('assinaturas.upgrade') }}" method="POST">
            @csrf
            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                {{ $assinatura ? 'Fazer Upgrade' : 'Assinar' }}
            </button>
        </form>
    @endif
@else
    <div class="w-full bg-gray-300 text-gray-600 py-2 px-4 rounded-lg text-center">
        Plano Atual
    </div>
@endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection