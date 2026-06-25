@extends('layouts.admin')

@section('content')

{{-- Cabeçalho da página --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
    <p class="text-sm text-slate-500 mt-1">
        Bem-vindo, {{ auth()->user()->name }}. Aqui está o resumo do seu negócio.
    </p>
</div>

{{-- ========================================
     CARDS DE INDICADORES (4 cards)
     ======================================== --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- Card 1: Faturamento do mês --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="bg-blue-50 p-2 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                </svg>
            </div>
            {{-- Badge de variação --}}
            @if($revenueVariation != 0)
                <span class="text-xs font-medium px-2 py-1 rounded-full
                    {{ $revenueVariation > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                    {{ $revenueVariation > 0 ? '↑' : '↓' }} {{ number_format(abs($revenueVariation), 1, ',', '.') }}%
                </span>
            @endif
        </div>
        <div class="text-xs text-slate-500 uppercase font-medium tracking-wide">Faturamento (mês)</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">
            R$ {{ number_format($revenueThisMonth, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 2: Despesas do mês --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="bg-amber-50 p-2 rounded-lg">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22M21.75 9V2.25L13.5 10.5"/>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500 uppercase font-medium tracking-wide">Despesas (mês)</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">
            R$ {{ number_format($expensesThisMonth, 2, ',', '.') }}
        </div>
    </div>

    {{-- Card 3: Clientes --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="bg-purple-50 p-2 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500 uppercase font-medium tracking-wide">Clientes</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalCustomers }}</div>
    </div>

    {{-- Card 4: Orçamentos --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex items-start justify-between mb-3">
            <div class="bg-indigo-50 p-2 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25"/>
                </svg>
            </div>
        </div>
        <div class="text-xs text-slate-500 uppercase font-medium tracking-wide">Orçamentos</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalQuotes }}</div>
    </div>

</div>

{{-- ========================================
     GRÁFICOS (2 colunas)
     ======================================== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">

    {{-- Gráfico de faturamento (ocupa 2 colunas) --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Faturamento</h2>
                <p class="text-xs text-slate-500">Últimos 6 meses</p>
            </div>
        </div>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    {{-- Gráfico de pizza de orçamentos --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-900">Orçamentos</h2>
            <p class="text-xs text-slate-500">Distribuição por status</p>
        </div>
        <canvas id="statusChart" height="160"></canvas>
    </div>

</div>

{{-- ========================================
     ÚLTIMAS ATIVIDADES
     ======================================== --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900">Últimos orçamentos</h2>
            <p class="text-xs text-slate-500">Atividade recente</p>
        </div>
        <a href="{{ route('quotes.index') }}" class="text-sm text-blue-600 hover:underline">
            Ver todos →
        </a>
    </div>

    @if($recentQuotes->isEmpty())
        {{-- Estado vazio --}}
        <div class="p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08"/>
            </svg>
            <p class="text-sm text-slate-500">Nenhum orçamento ainda.</p>
            <a href="{{ route('quotes.create') }}" class="text-sm text-blue-600 hover:underline mt-2 inline-block">
                Criar primeiro orçamento
            </a>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach($recentQuotes as $quote)
                @php
                    $statusConfig = [
                        'rascunho' => ['bg-slate-100', 'text-slate-700', 'Rascunho'],
                        'enviado'  => ['bg-blue-100', 'text-blue-700', 'Enviado'],
                        'aceito'   => ['bg-green-100', 'text-green-700', 'Aceito'],
                        'recusado' => ['bg-red-100', 'text-red-700', 'Recusado'],
                    ];
                    [$bg, $tc, $label] = $statusConfig[$quote->status];
                @endphp
                <a href="{{ route('quotes.show', $quote) }}" class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 text-sm">
                            {{ strtoupper(substr($quote->customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-medium text-slate-900">{{ $quote->customer->name }}</div>
                            <div class="text-xs text-slate-500">Orçamento #{{ $quote->id }} · {{ $quote->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $bg }} {{ $tc }}">{{ $label }}</span>
                        <span class="text-sm font-bold text-slate-900">R$ {{ number_format($quote->total, 2, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

{{-- ========================================
     SCRIPTS DOS GRÁFICOS
     ======================================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// === Gráfico de faturamento (barras) ===
const ctx1 = document.getElementById('revenueChart').getContext('2d');
const gradient = ctx1.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(37, 99, 235, 0.8)');
gradient.addColorStop(1, 'rgba(37, 99, 235, 0.2)');

new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Faturamento (R$)',
            data: @json($revenues),
            backgroundColor: gradient,
            borderColor: 'rgb(37, 99, 235)',
            borderWidth: 0,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR');
                    }
                }
            },
            x: { grid: { display: false } }
        }
    }
});

// === Gráfico de pizza dos orçamentos ===
const ctx2 = document.getElementById('statusChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Rascunho', 'Enviado', 'Aceito', 'Recusado'],
        datasets: [{
            data: [
                {{ $quotesByStatus['rascunho'] }},
                {{ $quotesByStatus['enviado'] }},
                {{ $quotesByStatus['aceito'] }},
                {{ $quotesByStatus['recusado'] }}
            ],
            backgroundColor: [
                'rgb(148, 163, 184)',  // slate
                'rgb(59, 130, 246)',   // blue
                'rgb(34, 197, 94)',    // green
                'rgb(239, 68, 68)'     // red
            ],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 12, boxWidth: 10, font: { size: 11 } }
            }
        }
    }
});
</script>

@endsection