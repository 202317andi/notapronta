@extends('layouts.admin')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('categories.index') }}" class="hover:text-blue-600">Categorias</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Editar</span>
</div>

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Editar categoria</h1>
    <p class="text-sm text-slate-500 mt-1">Atualize as informações desta categoria.</p>
</div>

{{-- Formulário --}}
<div class="max-w-xl">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nome da categoria <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $category->name) }}"
                   autofocus
                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                          @error('name') border-red-300 focus:ring-red-500 @enderror">

            @error('name')
                <p class="text-red-600 text-xs mt-2 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Metadata --}}
        <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 mb-4 text-xs text-slate-500">
            <div class="flex items-center justify-between">
                <span>Criada em {{ $category->created_at->format('d/m/Y \à\s H:i') }}</span>
                <span>Atualizada {{ $category->updated_at->diffForHumans() }}</span>
            </div>
        </div>

        {{-- Botões --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    Salvar alterações
                </button>
                <a href="{{ route('categories.index') }}"
                   class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

@endsection