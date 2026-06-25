@extends('layouts.admin')

@section('content')

<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Vendas</h1>
        <p class="text-sm text-slate-500 mt-1">Histórico de todas as vendas realizadas.</p>
    </div>
    <a href="{{ route('sales.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Nova venda
    </a>
</div>

@if($sales->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhuma venda ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Registre suas vendas para acompanhar o faturamento no dashboard.
        </p>
        <a href="{{ route('sales.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Registrar primeira venda
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Data</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Pagamento</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($sales as $sale)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-slate-500">#{{ $sale->id }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center font-bold text-white text-xs">
                                {{ strtoupper(substr($sale->customer->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $sale->customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($sale->payment_type === 'a_vista')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                À vista
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                A prazo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-green-600">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('sales.show', $sale) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                Ver
                            </a>
                            <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                                  class="inline" onsubmit="return confirm('Excluir esta venda?')">
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

    <div class="flex items-center justify-between mt-4">
        <p class="text-xs text-slate-500">
            Total: <span class="font-medium text-slate-700">{{ $sales->count() }}</span>
            {{ $sales->count() === 1 ? 'venda' : 'vendas' }}
        </p>
        <p class="text-xs text-slate-500">
            Faturamento total:
            <span class="font-bold text-green-600">R$ {{ number_format($sales->sum('total'), 2, ',', '.') }}</span>
        </p>
    </div>
@endif

@endsection