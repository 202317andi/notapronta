@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('sales.index') }}" class="hover:text-blue-600">Vendas</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Venda #{{ $sale->id }}</span>
</div>

<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Venda #{{ $sale->id }}</h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $sale->customer->name }} · {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
        </p>
    </div>
    @if($sale->payment_type === 'a_vista')
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-50 text-green-700">
            À vista
        </span>
    @else
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-amber-50 text-amber-700">
            A prazo
        </span>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    {{-- Coluna principal --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-900">Itens da venda</h3>
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
                    @foreach($sale->items as $item)
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
                        <td class="px-6 py-4 text-right text-xl font-bold text-green-600">
                            R$ {{ number_format($sale->total, 2, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Coluna lateral --}}
    <div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-bold text-slate-900 mb-4">Informações</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Cliente</span>
                    <span class="font-medium text-slate-900">{{ $sale->customer->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Data</span>
                    <span class="font-medium text-slate-900">
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Pagamento</span>
                    <span class="font-medium text-slate-900">
                        {{ $sale->payment_type === 'a_vista' ? 'À vista' : 'A prazo' }}
                    </span>
                </div>
                @if($sale->quote)
                <div class="flex justify-between">
                    <span class="text-slate-500">Orçamento</span>
                    <a href="{{ route('quotes.show', $sale->quote) }}" class="text-blue-600 hover:underline font-medium">
                        #{{ $sale->quote_id }}
                    </a>
                </div>
                @endif
                <div class="border-t border-slate-100 pt-3 flex justify-between">
                    <span class="font-semibold text-slate-700">Total</span>
                    <span class="font-bold text-green-600 text-lg">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection