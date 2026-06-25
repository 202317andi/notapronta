@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('products.index') }}" class="hover:text-blue-600">Produtos</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">{{ $product->name }}</span>
</div>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Editar produto</h1>
    <p class="text-sm text-slate-500 mt-1">Atualize as informações deste produto.</p>
</div>

<div class="max-w-xl">
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4 space-y-5">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Categoria <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nome <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" autofocus
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Descrição</label>
                <textarea name="description" rows="3"
                          class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Preço (R$) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">R$</span>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                           class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('price')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

        </div>

        <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 mb-4 text-xs text-slate-500 flex items-center justify-between">
            <span>Cadastrado em {{ $product->created_at->format('d/m/Y') }}</span>
            <span>Atualizado {{ $product->updated_at->diffForHumans() }}</span>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Salvar alterações
            </button>
            <a href="{{ route('products.index') }}"
               class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection