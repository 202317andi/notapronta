@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('expenses.index') }}" class="hover:text-blue-600">Despesas</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Nova despesa</span>
</div>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Nova despesa</h1>
    <p class="text-sm text-slate-500 mt-1">Registre uma saída de dinheiro do seu negócio.</p>
</div>

<div class="max-w-xl">
    <form method="POST" action="{{ route('expenses.store') }}">
        @csrf

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4 space-y-5">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Descrição <span class="text-red-500">*</span>
                </label>
                <input type="text" name="description" value="{{ old('description') }}" autofocus
                       placeholder="Ex: Aluguel, Internet, Material de escritório"
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('description')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Valor (R$) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">R$</span>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0"
                               placeholder="0,00"
                               class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    @error('amount')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Data <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('expense_date')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Salvar despesa
            </button>
            <a href="{{ route('expenses.index') }}"
               class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection