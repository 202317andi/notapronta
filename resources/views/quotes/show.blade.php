@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('quotes.index') }}" class="hover:text-blue-600">Orçamentos</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Orçamento #{{ $quote->id }}</span>
</div>

<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Orçamento #{{ $quote->id }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $quote->customer->name }} · {{ $quote->created_at->format('d/m/Y') }}</p>
    </div>
    @php
        $statusConfig = [
            'rascunho' => ['bg-slate-100', 'text-slate-700', 'Rascunho'],
            'enviado'  => ['bg-blue-50', 'text-blue-700', 'Enviado'],
            'aceito'   => ['bg-green-50', 'text-green-700', '✓ Aceito'],
            'recusado' => ['bg-red-50', 'text-red-700', '✗ Recusado'],
        ];
        [$bg, $tc, $label] = $statusConfig[$quote->status];
    @endphp
    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $bg }} {{ $tc }}">
        {{ $label }}
    </span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    {{-- Coluna principal --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Itens --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-900">Itens do orçamento</h3>
            </div>
            <table class="w-full">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Produto</th>
                        <th class="px-6 py-3 text-right">Qtd</th>
                        <th class="px-6 py-3 text-right">Preço</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($quote->items as $item)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 text-right text-slate-600">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right text-slate-600">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-900">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50 border-t border-slate-200">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold text-slate-700">Total</td>
                        <td class="px-6 py-4 text-right text-xl font-bold text-slate-900">R$ {{ number_format($quote->total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($quote->notes)
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-4">
            <div class="text-xs font-bold text-blue-900 uppercase mb-1">Observações</div>
            <p class="text-sm text-blue-800">{{ $quote->notes }}</p>
        </div>
        @endif

    </div>

    {{-- Coluna lateral --}}
    <div class="space-y-4">

        {{-- Resumo --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-bold text-slate-900 mb-4">Informações</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Cliente</span>
                    <span class="font-medium text-slate-900">{{ $quote->customer->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <span class="font-medium text-slate-900">{{ $label }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Criado em</span>
                    <span class="font-medium text-slate-900">{{ $quote->created_at->format('d/m/Y') }}</span>
                </div>
                @if($quote->sent_at)
                <div class="flex justify-between">
                    <span class="text-slate-500">Enviado em</span>
                    <span class="font-medium text-slate-900">{{ $quote->sent_at->format('d/m/Y') }}</span>
                </div>
                @endif
                @if($quote->responded_at)
                <div class="flex justify-between">
                    <span class="text-slate-500">Respondido em</span>
                    <span class="font-medium text-slate-900">{{ $quote->responded_at->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Link público --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-bold text-slate-900 mb-1">Link do cliente</h3>
            <p class="text-xs text-slate-500 mb-3">Envie por WhatsApp ou e-mail</p>
            <div class="flex gap-2 mb-3">
                <input type="text" readonly
                       value="{{ route('public.quote', $quote->public_token) }}"
                       onclick="this.select()"
                       class="flex-1 px-2 py-1.5 border border-slate-300 rounded-lg text-xs bg-slate-50 text-slate-700 cursor-pointer">
            </div>
            <a href="{{ route('public.quote', $quote->public_token) }}" target="_blank"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-900 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Ver como cliente
            </a>
        </div>

        {{-- Ações --}}
        @if($quote->status === 'rascunho')
        <form method="POST" action="{{ route('quotes.send', $quote) }}">
            @csrf
            <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>
                Marcar como enviado
            </button>
        </form>
        @endif

    </div>
</div>

@endsection