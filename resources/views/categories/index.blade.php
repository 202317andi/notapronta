@extends('layouts.admin')

@section('content')

{{-- Cabeçalho da página --}}
<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Categorias</h1>
        <p class="text-sm text-slate-500 mt-1">Organize seus produtos e serviços em categorias.</p>
    </div>
    <a href="{{ route('categories.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Nova categoria
    </a>
</div>

@if($categories->isEmpty())
    {{-- Estado vazio --}}
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhuma categoria ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Categorias ajudam a organizar seus produtos. Exemplo: "Bebidas", "Alimentos", "Serviços".
        </p>
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Criar primeira categoria
        </a>
    </div>
@else
    {{-- Tabela --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Criada em</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($categories as $category)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center font-bold text-blue-600 text-sm">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $category->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                </svg>
                                Editar
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                  class="inline" onsubmit="return confirm('Excluir esta categoria? Os produtos vinculados também podem ser afetados.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
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

    {{-- Contador no rodapé --}}
    <p class="text-xs text-slate-500 mt-4">
        Total: <span class="font-medium text-slate-700">{{ $categories->count() }}</span>
        {{ $categories->count() === 1 ? 'categoria' : 'categorias' }}
    </p>
@endif

@endsection