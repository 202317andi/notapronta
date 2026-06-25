@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('customers.index') }}" class="hover:text-blue-600">Clientes</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Novo cliente</span>
</div>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Novo cliente</h1>
    <p class="text-sm text-slate-500 mt-1">Preencha os dados do cliente. Só o nome é obrigatório.</p>
</div>

<div class="max-w-xl">
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4 space-y-5">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nome <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" autofocus
                       placeholder="Ex: Maria Silva"
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="exemplo@email.com"
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="(00) 00000-0000"
                           class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">CPF / CNPJ</label>
                    <input type="text" name="document" value="{{ old('document') }}"
                           placeholder="000.000.000-00"
                           class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Salvar cliente
            </button>
            <a href="{{ route('customers.index') }}"
               class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection