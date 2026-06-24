@extends('layouts.admin')

@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Produto</h1>

    <div class="bg-white rounded shadow p-6">
        @if($categories->isEmpty())
            <p class="text-red-500 mb-4 text-sm">
                Você precisa cadastrar pelo menos uma categoria antes.
                <a href="{{ route('categories.create') }}" class="underline">Criar categoria</a>
            </p>
        @endif

        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria *</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">Selecione...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea name="description" rows="3"
                          class="w-full border rounded px-3 py-2 text-sm">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Preço (R$) *</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                       class="w-full border rounded px-3 py-2 text-sm">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                    Salvar
                </button>
                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 rounded border text-sm text-gray-600 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection