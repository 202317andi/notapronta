<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Orçamento #{{ $quote->id }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen py-10">

<div class="max-w-2xl mx-auto bg-white shadow rounded p-8">
    <h1 class="text-3xl font-bold text-indigo-600 mb-2">Orçamento</h1>
    <p class="text-gray-500 mb-6">De: <strong>{{ $quote->user->name }}</strong></p>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="mb-4 text-sm">
        <p><strong>Para:</strong> {{ $quote->customer->name }}</p>
        <p><strong>Data:</strong> {{ $quote->created_at->format('d/m/Y') }}</p>
        <p><strong>Status:</strong> <span class="font-bold">{{ ucfirst($quote->status) }}</span></p>
    </div>

    <table class="w-full text-sm border-t border-b mb-4">
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

    <div class="text-right text-xl font-bold mb-6">
        Total: R$ {{ number_format($quote->total, 2, ',', '.') }}
    </div>

    @if($quote->notes)
        <p class="text-sm text-gray-600 mb-6"><em>{{ $quote->notes }}</em></p>
    @endif

    @if($quote->status === 'enviado')
        <div class="flex gap-2">
            <form method="POST" action="{{ route('public.quote.accept', $quote->public_token) }}" class="flex-1">
                @csrf
                <button class="w-full bg-green-600 text-white py-3 rounded font-bold hover:bg-green-700">
                    ✓ Aceitar Orçamento
                </button>
            </form>
            <form method="POST" action="{{ route('public.quote.reject', $quote->public_token) }}" class="flex-1">
                @csrf
                <button class="w-full bg-red-600 text-white py-3 rounded font-bold hover:bg-red-700">
                    ✗ Recusar
                </button>
            </form>
        </div>
    @elseif($quote->status === 'aceito')
        <div class="bg-green-100 text-green-800 p-4 rounded text-center font-bold">
            ✓ Você aceitou este orçamento!
        </div>
    @elseif($quote->status === 'recusado')
        <div class="bg-red-100 text-red-800 p-4 rounded text-center font-bold">
            ✗ Você recusou este orçamento.
        </div>
    @else
        <div class="bg-gray-100 text-gray-600 p-4 rounded text-center text-sm">
            Este orçamento ainda não está disponível para resposta.
        </div>
    @endif

</div>

</body>
</html>