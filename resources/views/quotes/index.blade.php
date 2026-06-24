@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Orçamentos</h1>
    <a href="{{ route('quotes.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
        Novo Orçamento
    </a>
</div>

@if($quotes->isEmpty())
    <p class="text-gray-500">Nenhum orçamento criado ainda.</p>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Cliente</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Criado em</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($quotes as $quote)
                <tr>
                    <td class="px-6 py-4 text-gray-800">#{{ $quote->id }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ $quote->customer->name }}</td>
                    <td class="px-6 py-4 text-gray-800">R$ {{ number_format($quote->total, 2, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'rascunho' => 'bg-gray-200 text-gray-700',
                                'enviado' => 'bg-blue-100 text-blue-700',
                                'aceito' => 'bg-green-100 text-green-700',
                                'recusado' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $colors[$quote->status] }}">
                            {{ ucfirst($quote->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $quote->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('quotes.show', $quote) }}"
                           class="text-indigo-600 hover:underline">Ver</a>
                        <form method="POST" action="{{ route('quotes.destroy', $quote) }}"
                              class="inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection