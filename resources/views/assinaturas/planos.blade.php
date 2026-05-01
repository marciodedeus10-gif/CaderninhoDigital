@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Título -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Escolha o Plano Perfeito</h1>
        <p class="text-xl text-gray-600">Encontre o plano ideal para seu negócio</p>
    </div>

    <!-- Cards dos Planos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        @foreach($planos as $plano)
            <div class="relative bg-white rounded-xl shadow-lg overflow-hidden transition transform hover:scale-105 {{ $plano->nome === 'Ouro' ? 'ring-4 ring-yellow-400 md:scale-105' : '' }}">
                <!-- Badge Mais Popular -->
                @if($plano->nome === 'Ouro')
                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-center py-2 font-bold text-sm">
                        ⭐ MAIS POPULAR
                    </div>
                @endif

                <div class="pt-8 px-6 pb-6">
                    <!-- Nome do Plano -->
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $plano->nome }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ $plano->descricao }}</p>

                    <!-- Preço -->
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-gray-900">
                            R$ {{ number_format($plano->preco_mensal, 2, ',', '.') }}
                            <span class="text-lg text-gray-600 font-normal">/mês</span>
                        </div>
                        @if($plano->preco_anual)
                            <div class="text-sm text-gray-600">
                                ou R$ {{ number_format($plano->preco_anual, 2, ',', '.') }}/ano
                                <span class="text-green-600 font-semibold">-17% de desconto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Usuários -->
                    <div class="mb-6 pb-6 border-b-2 border-gray-200">
                        <p class="text-sm font-semibold text-gray-700">Usuários:</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $plano->max_usuarios ?: '∞ Ilimitado' }}
                        </p>
                    </div>

                    <!-- Vantagens -->
                    @if($plano->vantagens)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">✅ Vantagens:</h3>
                            <ul class="space-y-2">
                                @foreach($plano->vantagens as $vantagem)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $vantagem }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Desvantagens -->
                    @if($plano->desvantagens && count($plano->desvantagens) > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">❌ Limitações:</h3>
                            <ul class="space-y-2">
                                @foreach($plano->desvantagens as $desvantagem)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $desvantagem }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p class="text-sm text-yellow-800 font-semibold">✨ Sem limitações! Todos os recursos disponíveis.</p>
                        </div>
                    @endif

                    <!-- Botão -->
                    @if($assinatura && $assinatura->plano_id == $plano->id)
                        <button class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold">
                            ✓ Plano Atual
                        </button>
                    @else
                        <form action="{{ route('assinaturas.upgrade') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano_id" value="{{ $plano->id }}">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200">
                                {{ $assinatura ? 'Fazer Upgrade' : 'Começar Agora' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabela Comparativa -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Comparação Detalhada de Recursos</h2>
        
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Recurso</th>
                        @foreach($planos as $plano)
                            <th class="px-6 py-4 text-center font-semibold text-gray-900">
                                <div class="text-lg">{{ $plano->nome }}</div>
                                <div class="text-sm text-gray-600">
                                    R$ {{ number_format($plano->preco_mensal, 2, ',', '.') }}/mês
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Usuários -->
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900">👥 Usuários</td>
                        @foreach($planos as $plano)
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-blue-600">
                                    {{ $plano->max_usuarios ?: 'Ilimitado' }}
                                </span>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Recursos -->
                    @php
                        $todos_recursos = collect();
                        foreach($planos as $plano) {
                            $todos_recursos = $todos_recursos->merge($plano->recursos ?? []);
                        }
                        $todos_recursos = $todos_recursos->unique()->sort();
                    @endphp

                    @foreach($todos_recursos as $recurso)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-700">
                                {{ ucfirst(str_replace('_', ' ', $recurso)) }}
                            </td>
                            @foreach($planos as $plano)
                                <td class="px-6 py-4 text-center">
                                    @if(in_array($recurso, $plano->recursos ?? []))
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-100 rounded-full">
                                            <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    <!-- Suporte -->
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900">📞 Suporte</td>
                        <td class="px-6 py-4 text-center text-gray-700">Email</td>
                        <td class="px-6 py-4 text-center text-gray-700">Email Prioritário</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-semibold">
                                24/7 Telefone
                            </span>
                        </td>
                    </tr>

                    <!-- API -->
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900">🔌 API</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-red-600 font-bold">✗</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-red-600 font-bold">✗</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-green-600 font-bold">✓</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-xl p-12 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Pronto para começar?</h2>
        <p class="text-xl mb-8 opacity-90">Escolha seu plano e comece a usar agora mesmo!</p>
        <a href="#" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-200">
            Ver Minha Assinatura
        </a>
    </div>
</div>

<style>
    table tr:nth-child(even) {
        background-color: #f9fafb;
    }
</style>
@endsection