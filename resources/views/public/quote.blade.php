<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento #{{ $quote->id }} — {{ $quote->user->name }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-100 min-h-screen py-6 md:py-12 px-4">

<div class="max-w-2xl mx-auto">

    {{-- ========================================
         CABEÇALHO COM LOGO DO EMPRESÁRIO
         ======================================== --}}
    <div class="bg-white rounded-t-2xl px-6 md:px-10 py-6 border-b border-slate-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 w-11 h-11 rounded-xl flex items-center justify-center font-bold text-white text-lg">
                    {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-slate-900">{{ $quote->user->name }}</div>
                    <div class="text-xs text-slate-500">Orçamento enviado para você</div>
                </div>
            </div>

            {{-- Badge de status --}}
            @php
                $statusBadge = [
                    'rascunho' => ['bg-slate-100', 'text-slate-700', 'Rascunho'],
                    'enviado'  => ['bg-blue-50', 'text-blue-700', 'Aguardando resposta'],
                    'aceito'   => ['bg-green-50', 'text-green-700', '✓ Aceito'],
                    'recusado' => ['bg-red-50', 'text-red-700', '✗ Recusado'],
                ];
                [$bg, $tc, $label] = $statusBadge[$quote->status];
            @endphp
            <span class="hidden md:inline-block text-xs font-medium px-3 py-1 rounded-full {{ $bg }} {{ $tc }}">
                {{ $label }}
            </span>
        </div>
    </div>

    {{-- Mensagem de sucesso (após aceitar/recusar) --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ========================================
         CORPO DO ORÇAMENTO
         ======================================== --}}
    <div class="bg-white px-6 md:px-10 py-6">

        {{-- Título grande --}}
        <div class="mb-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider mb-1">Orçamento #{{ $quote->id }}</div>
            <h1 class="text-3xl font-bold text-slate-900">
                R$ {{ number_format($quote->total, 2, ',', '.') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Para: <span class="font-medium text-slate-700">{{ $quote->customer->name }}</span>
            </p>
        </div>

        {{-- Datas --}}
        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100 mb-6 text-sm">
            <div>
                <div class="text-xs text-slate-500 uppercase mb-1">Data de emissão</div>
                <div class="font-medium text-slate-900">{{ $quote->created_at->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500 uppercase mb-1">Status</div>
                <div class="font-medium text-slate-900">{{ $label }}</div>
            </div>
        </div>

        {{-- Tabela de itens --}}
        <div class="mb-6">
            <h3 class="text-sm font-bold text-slate-900 mb-3">Itens</h3>
            <div class="space-y-2">
                @foreach($quote->items as $item)
                    <div class="flex items-start justify-between py-3 border-b border-slate-100 last:border-0">
                        <div class="flex-1">
                            <div class="font-medium text-slate-900 text-sm">{{ $item->product->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $item->quantity }} × R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="font-bold text-slate-900 text-sm">
                            R$ {{ number_format($item->subtotal, 2, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Total --}}
        <div class="bg-slate-50 rounded-lg p-4 flex items-center justify-between mb-6">
            <span class="text-sm font-medium text-slate-600">Total geral</span>
            <span class="text-2xl font-bold text-slate-900">
                R$ {{ number_format($quote->total, 2, ',', '.') }}
            </span>
        </div>

        {{-- Observações --}}
        @if($quote->notes)
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <div class="text-xs font-bold text-blue-900 uppercase mb-2">Observações</div>
                <p class="text-sm text-blue-800">{{ $quote->notes }}</p>
            </div>
        @endif

    </div>

    {{-- ========================================
         BOTÕES DE AÇÃO
         ======================================== --}}
    <div class="bg-white rounded-b-2xl px-6 md:px-10 py-6 border-t border-slate-100">

        @if($quote->status === 'enviado')
            <p class="text-sm text-slate-600 mb-4 text-center">
                O que você quer fazer com este orçamento?
            </p>
            <div class="flex flex-col md:flex-row gap-3">
                <form method="POST" action="{{ route('public.quote.accept', $quote->public_token) }}" class="flex-1">
                    @csrf
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                        Aceitar orçamento
                    </button>
                </form>
                <form method="POST" action="{{ route('public.quote.reject', $quote->public_token) }}" class="flex-1">
                    @csrf
                    <button class="w-full bg-white border border-slate-300 hover:border-red-300 hover:bg-red-50 text-slate-700 hover:text-red-700 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                        Recusar
                    </button>
                </form>
            </div>

        @elseif($quote->status === 'aceito')
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                </div>
                <h3 class="font-bold text-green-900 mb-1">Orçamento aceito!</h3>
                <p class="text-sm text-green-700">{{ $quote->user->name }} foi notificado e entrará em contato.</p>
            </div>

        @elseif($quote->status === 'recusado')
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h3 class="font-bold text-red-900 mb-1">Orçamento recusado</h3>
                <p class="text-sm text-red-700">Esse orçamento foi marcado como recusado.</p>
            </div>

        @else
            <div class="bg-slate-50 rounded-xl p-4 text-center text-sm text-slate-600">
                Este orçamento ainda não foi enviado pelo fornecedor.
            </div>
        @endif

    </div>

    {{-- Rodapé --}}
    <div class="text-center mt-6 text-xs text-slate-400">
        Enviado via <span class="font-medium text-slate-500">NotaPronta</span>
    </div>

</div>

</body>
</html>