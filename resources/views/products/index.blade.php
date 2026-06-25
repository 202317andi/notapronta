@extends('layouts.admin')

@section('content')

<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Produtos</h1>
        <p class="text-sm text-slate-500 mt-1">Cadastre os produtos e serviços que você vende.</p>
    </div>
    <a href="{{ route('products.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Novo produto
    </a>
</div>

@if($products->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-emerald-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhum produto ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Cadastre seus produtos e serviços com preços.
        </p>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Cadastrar primeiro produto
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Produto</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Categoria</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Preço</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($products as $product)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-900">{{ $product->name }}</div>
                                @if($product->description)
                                    <div class="text-xs text-slate-500 max-w-xs">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->category)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $product->category->name }}
                            </span>
                        @else
                            <span class="text-slate-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-slate-900">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('products.edit', $product) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}"
                                  class="inline" onsubmit="return confirm('Excluir este produto?')">
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
        Total: <span class="font-medium text-slate-700">{{ $products->count() }}</span>
        {{ $products->count() === 1 ? 'produto' : 'produtos' }}
    </p>
@endif

@endsection