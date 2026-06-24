@extends('layouts.admin')

@section('content')
<div class="max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Venda #{{ $sale->id }}</h1>
        <a href="{{ route('sales.index') }}" class="text-gray-500 hover:underline text-sm">← Voltar</a>
    </div>

    <div class="bg-white rounded shadow p-6">
        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
            <div><strong>Cliente:</strong> {{ $sale->customer->name }}</div>
            <div><strong>Data:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</div>
            <div><strong>Pagamento:</strong>
                {{ $sale->payment_type === 'a_vista' ? 'À vista' : 'A prazo' }}
            </div>
            <div><strong>Total:</strong>
                <span class="text-green-600 font-bold">
                    R$ {{ number_format($sale->total, 2, ',', '.') }}
                </span>
            </div>
        </div>

        <table class="w-full text-sm border-t">
            <thead class="text-gray-600 uppercase text-xs">
                <tr>
                    <th class="py-2 text-left">Produto</th>
                    <th class="py-2 text-right">Qtd</th>
                    <th class="py-2 text-right">Preço</th>
                    <th class="py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($sale->items as $item)
                <tr>
                    <td class="py-2">{{ $item->product->name }}</td>
                    <td class="py-2 text-right">{{ $item->quantity }}</td>
                    <td class="py-2 text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="py-2 text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection