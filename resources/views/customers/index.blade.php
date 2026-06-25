@extends('layouts.admin')

@section('content')

{{-- Cabeçalho --}}
<div class="flex items-start justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Clientes</h1>
        <p class="text-sm text-slate-500 mt-1">Gerencie seus clientes e o histórico de compras.</p>
    </div>
    <a href="{{ route('customers.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Novo cliente
    </a>
</div>

@if($customers->isEmpty())
    {{-- Estado vazio --}}
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1">Nenhum cliente ainda</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-sm mx-auto">
            Cadastre seus clientes para criar orçamentos e vendas mais rápido.
        </p>
        <a href="{{ route('customers.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            Cadastrar primeiro cliente
        </a>
    </div>
@else
    {{-- Tabela --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Contato</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">CPF/CNPJ</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($customers as $customer)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center font-bold text-white text-sm">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-900">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($customer->email)
                            <div class="text-slate-700">{{ $customer->email }}</div>
                        @endif
                        @if($customer->phone)
                            <div class="text-slate-500 text-xs">{{ $customer->phone }}</div>
                        @endif
                        @if(!$customer->email && !$customer->phone)
                            <span class="text-slate-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $customer->document ?? '—' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('customers.edit', $customer) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                </svg>
                                Editar
                            </a>
                            <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                  class="inline" onsubmit="return confirm('Excluir este cliente? Esta ação não pode ser desfeita.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165"/>
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

    <p class="text-xs text-slate-500 mt-4">
        Total: <span class="font-medium text-slate-700">{{ $customers->count() }}</span>
        {{ $customers->count() === 1 ? 'cliente' : 'clientes' }}
    </p>
@endif

@endsection