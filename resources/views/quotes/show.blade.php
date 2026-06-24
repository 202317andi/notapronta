@extends('layouts.admin')

@section('content')
<div class="max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Orçamento #{{ $quote->id }}</h1>
        <a href="{{ route('quotes.index') }}" class="text-gray-500 hover:underline text-sm">← Voltar</a>
    </div>

    <div class="bg-white rounded shadow p-6 mb-4">
        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
            <div><strong>Cliente:</strong> {{ $quote->customer->name }}</div>
            <div><strong>Status:</strong> {{ ucfirst($quote->status) }}</div>
            <div><strong>Criado em:</strong> {{ $quote->created_at->format('d/m/Y H:i') }}</div>
            <div><strong>Total:</strong> R$ {{ number_format($quote->total, 2, ',', '.') }}</div>
        </div>

        @if($quote->notes)
            <p class="text-sm text-gray-600 mb-4"><strong>Observações:</strong> {{ $quote->notes }}</p>
        @endif

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
                @foreach($quote->items as $item)
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

    <div class="bg-indigo-50 rounded p-4 mb-4 text-sm">
        <strong>🔗 Link público para o cliente:</strong>
        <div class="mt-2 flex gap-2">
            <input type="text" readonly
                   value="{{ route('public.quote', $quote->public_token) }}"
                   class="flex-1 border rounded px-2 py-1 text-xs"
                   onclick="this.select()">
            <a href="{{ route('public.quote', $quote->public_token) }}" target="_blank"
               class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">Abrir</a>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Envie esse link pelo WhatsApp ou e-mail. O cliente abre direto, sem precisar de senha.
        </p>
    </div>

    @if($quote->status === 'rascunho')
        <form method="POST" action="{{ route('quotes.send', $quote) }}">
            @csrf
            <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                ✓ Marcar como Enviado
            </button>
        </form>
    @endif
</div>
@endsection