@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Vendas</h1>
    <a href="{{ route('sales.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
        Nova Venda
    </a>
</div>

@if($sales->isEmpty())
    <p class="text-gray-500">Nenhuma venda registrada ainda.</p>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Data</th>
                    <th class="px-6 py-3 text-left">Cliente</th>
                    <th class="px-6 py-3 text-left">Pagamento</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sales as $sale)
                <tr>
                    <td class="px-6 py-4 text-gray-800">#{{ $sale->id }}</td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-800">{{ $sale->customer->name }}</td>
                    <td class="px-6 py-4">
                        @if($sale->payment_type === 'a_vista')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">À vista</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">A prazo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-green-600 font-bold">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('sales.show', $sale) }}"
                           class="text-indigo-600 hover:underline">Ver</a>
                        <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                              class="inline" onsubmit="return confirm('Excluir esta venda?')">
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