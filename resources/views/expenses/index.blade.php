@extends('layouts.admin')

@section('content')

<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Despesas</h1>
        <p class="text-sm text-slate-500 mt-1">Acompanhe os gastos do seu negócio.</p>
    </div>
    <a href="{{ route('expenses.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Nova despesa
    </a>
</div>

@if($expenses->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-amber-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22M21.75 9V2.25L13.5 10.5"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhuma despesa ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Registre despesas como aluguel, contas, materiais. Aparecem no dashboard.
        </p>
        <a href="{{ route('expenses.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Registrar primeira despesa
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Data</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Descrição</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Valor</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($expenses as $expense)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75"/>
                                </svg>
                            </div>
                            <span class="font-medium text-slate-900">{{ $expense->description }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-red-600">- R$ {{ number_format($expense->amount, 2, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('expenses.edit', $expense) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                  class="inline" onsubmit="return confirm('Excluir esta despesa?')">
                                @csrf
                                @method('DELETE')
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
        Total: <span class="font-medium text-slate-700">{{ $expenses->count() }}</span>
        {{ $expenses->count() === 1 ? 'despesa' : 'despesas' }}
        · Soma: <span class="font-medium text-red-600">R$ {{ number_format($expenses->sum('amount'), 2, ',', '.') }}</span>
    </p>
@endif

@endsection