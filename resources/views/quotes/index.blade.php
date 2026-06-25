@extends('layouts.admin')

@section('content')

<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Orçamentos</h1>
        <p class="text-sm text-slate-500 mt-1">Crie e envie orçamentos para seus clientes.</p>
    </div>
    <a href="{{ route('quotes.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Novo orçamento
    </a>
</div>

@if($quotes->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-indigo-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhum orçamento ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Crie um orçamento, envie o link pro cliente e aguarde a resposta.
        </p>
        <a href="{{ route('quotes.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Criar primeiro orçamento
        </a>
    </div>
@else
    @php
        $statusConfig = [
            'rascunho' => ['bg-slate-100', 'text-slate-700', 'Rascunho'],
            'enviado'  => ['bg-blue-50', 'text-blue-700', 'Enviado'],
            'aceito'   => ['bg-green-50', 'text-green-700', 'Aceito'],
            'recusado' => ['bg-red-50', 'text-red-700', 'Recusado'],
        ];
    @endphp

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Criado</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($quotes as $quote)
                @php [$bg, $tc, $label] = $statusConfig[$quote->status]; @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-slate-500">#{{ $quote->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-full flex items-center justify-center font-bold text-white text-xs">
                                {{ strtoupper(substr($quote->customer->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $quote->customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $bg }} {{ $tc }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900">
                        R$ {{ number_format($quote->total, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $quote->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('quotes.show', $quote) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                Ver
                            </a>
                            <form method="POST" action="{{ route('quotes.destroy', $quote) }}"
                                  class="inline" onsubmit="return confirm('Excluir este orçamento?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-xs text-slate-500 mt-4">
        Total: <span class="font-medium text-slate-700">{{ $quotes->count() }}</span>
        {{ $quotes->count() === 1 ? 'orçamento' : 'orçamentos' }}
    </p>
@endif

@endsection