@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard</h1>
<p class="text-gray-500 mb-6">Bem-vindo, {{ auth()->user()->name }}! 👋</p>

<!-- Cards de estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Clientes</div>
        <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalCustomers }}</div>
    </div>

    <div class="bg-white rounded shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Produtos</div>
        <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalProducts }}</div>
    </div>

    <div class="bg-white rounded shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Orçamentos</div>
        <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalQuotes }}</div>
    </div>

    <div class="bg-white rounded shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Faturamento (aceitos)</div>
        <div class="text-2xl font-bold text-green-600 mt-2">
            R$ {{ number_format($totalRevenue, 2, ',', '.') }}
        </div>
    </div>
</div>

<!-- Gráfico -->
<div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Faturamento dos últimos 6 meses</h2>
    <canvas id="revenueChart" height="80"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Faturamento (R$)',
            data: @json($values),
            backgroundColor: 'rgba(79, 70, 229, 0.7)',
            borderColor: 'rgb(79, 70, 229)',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR');
                    }
                }
            }
        }
    }
});
</script>
@endsection