<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Expense;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // ===== CARDS PRINCIPAIS =====
        $totalCustomers = Customer::where('user_id', $userId)->count();
        $totalProducts  = Product::where('user_id', $userId)->count();
        $totalQuotes    = Quote::where('user_id', $userId)->count();

        // Faturamento = vendas registradas (mês atual)
        $revenueThisMonth = Sale::where('user_id', $userId)
            ->whereYear('sale_date', now()->year)
            ->whereMonth('sale_date', now()->month)
            ->sum('total');

        // Faturamento mês passado (pra calcular variação %)
        $revenueLastMonth = Sale::where('user_id', $userId)
            ->whereYear('sale_date', now()->subMonth()->year)
            ->whereMonth('sale_date', now()->subMonth()->month)
            ->sum('total');

        // Calcula variação percentual (evita divisão por zero)
        $revenueVariation = $revenueLastMonth > 0
            ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100
            : 0;

        // Despesas do mês
        $expensesThisMonth = Expense::where('user_id', $userId)
            ->whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month)
            ->sum('amount');

        // ===== GRÁFICO 1: faturamento últimos 6 meses =====
        $months = [];
        $revenues = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M/y');

            $total = Sale::where('user_id', $userId)
                ->whereYear('sale_date', $date->year)
                ->whereMonth('sale_date', $date->month)
                ->sum('total');

            $revenues[] = (float) $total;
        }

        // ===== GRÁFICO 2: orçamentos por status =====
        $quotesByStatus = [
            'rascunho' => Quote::where('user_id', $userId)->where('status', 'rascunho')->count(),
            'enviado'  => Quote::where('user_id', $userId)->where('status', 'enviado')->count(),
            'aceito'   => Quote::where('user_id', $userId)->where('status', 'aceito')->count(),
            'recusado' => Quote::where('user_id', $userId)->where('status', 'recusado')->count(),
        ];

        // ===== ÚLTIMAS ATIVIDADES (5 orçamentos mais recentes) =====
        $recentQuotes = Quote::where('user_id', $userId)
            ->with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalQuotes',
            'revenueThisMonth',
            'revenueVariation',
            'expensesThisMonth',
            'months',
            'revenues',
            'quotesByStatus',
            'recentQuotes'
        ));
    }
}