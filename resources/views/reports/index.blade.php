@extends('layouts.admin')

@section('content')

<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Relatórios</h1>
        <p class="text-sm text-slate-500 mt-1">Resumo financeiro por período.</p>
    </div>
</div>

{{-- Filtro de período --}}
<div class="bg-white rounded-xl border border-slate-200 p-5 mb-6">
    <form method="GET" action="{{ route('reports.index') }}" class="flex items-end gap-4">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Mês</label>
            <select name="month" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromDate(null, $m, 1)->locale('pt_BR')->isoFormat('MMMM') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ano</label>
            <select name="year" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                @foreach(range(now()->year, now()->year - 3, -1) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Filtrar
        </button>

        {{-- Botão baixar PDF --}}
        <a href="{{ route('reports.pdf', ['month' => $month, 'year' => $year]) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
            Baixar PDF
        </a>
    </form>
</div>

{{-- Cards de resumo --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <div class="text-xs text-slate-500 uppercase font-medium mb-2">Faturamento</div>
        <div class="text-2xl font-bold text-green-600">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
        <div class="text-xs text-slate-500 mt-1">{{ $sales->count() }} {{ $sales->count() === 1 ? 'venda' : 'vendas' }}</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <div class="text-xs text-slate-500 uppercase font-medium mb-2">Despesas</div>
        <div class="text-2xl font-bold text-red-600">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</div>
        <div class="text-xs text-slate-500 mt-1">{{ $expenses->count() }} {{ $expenses->count() === 1 ? 'registro' : 'registros' }}</div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <div class="text-xs text-slate-500 uppercase font-medium mb-2">Lucro estimado</div>
        <div class="text-2xl font-bold {{ $totalProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">
            R$ {{ number_format($totalProfit, 2, ',', '.') }}
        </div>
        <div class="text-xs text-slate-500 mt-1">{{ $quotesAccepted }} orçamentos aceitos</div>
    </div>
</div>

{{-- Tabela de vendas --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="font-bold text-slate-900">Vendas do período</h3>
        <span class="text-sm text-slate-500">{{ $sales->count() }} registros</span>
    </div>

    @if($sales->isEmpty())
        <div class="p-8 text-center text-sm text-slate-500">Nenhuma venda neste período.</div>
    @else
        <table class="w-full">
            <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Data</th>
                    <th class="px-6 py-3 text-left">Cliente</th>
                    <th class="px-6 py-3 text-left">Pagamento</th>
                    <th class="px-6 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($sales as $sale)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm text-slate-700">
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-3 font-medium text-slate-900">{{ $sale->customer->name }}</td>
                    <td class="px-6 py-3">
                        <span class="text-xs px-2 py-1 rounded-full {{ $sale->payment_type === 'a_vista' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $sale->payment_type === 'a_vista' ? 'À vista' : 'A prazo' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right font-bold text-green-600">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 border-t border-slate-200">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right font-semibold text-slate-700">Total</td>
                    <td class="px-6 py-3 text-right font-bold text-green-600">
                        R$ {{ number_format($totalRevenue, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>

{{-- Tabela de despesas --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="font-bold text-slate-900">Despesas do período</h3>
        <span class="text-sm text-slate-500">{{ $expenses->count() }} registros</span>
    </div>

    @if($expenses->isEmpty())
        <div class="p-8 text-center text-sm text-slate-500">Nenhuma despesa neste período.</div>
    @else
        <table class="w-full">
            <thead class="bg-slate-50 text-xs font-semibold text-slate-600 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Data</th>
                    <th class="px-6 py-3 text-left">Descrição</th>
                    <th class="px-6 py-3 text-right">Valor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($expenses as $expense)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm text-slate-700">
                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-3 font-medium text-slate-900">{{ $expense->description }}</td>
                    <td class="px-6 py-3 text-right font-bold text-red-600">
                        R$ {{ number_format($expense->amount, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 border-t border-slate-200">
                <tr>
                    <td colspan="2" class="px-6 py-3 text-right font-semibold text-slate-700">Total</td>
                    <td class="px-6 py-3 text-right font-bold text-red-600">
                        R$ {{ number_format($totalExpenses, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>

@endsection