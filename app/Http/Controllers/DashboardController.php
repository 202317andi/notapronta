<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Estatísticas dos cards
        $totalCustomers = Customer::where('user_id', $userId)->count();
        $totalProducts = Product::where('user_id', $userId)->count();
        $totalQuotes = Quote::where('user_id', $userId)->count();
        $totalRevenue = Quote::where('user_id', $userId)
            ->where('status', 'aceito')
            ->sum('total');

        // Dados do gráfico — orçamentos aceitos por mês (últimos 6 meses)
        $months = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M/Y');

            $total = Quote::where('user_id', $userId)
                ->where('status', 'aceito')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');

            $values[] = (float) $total;
        }

        return view('dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalQuotes',
            'totalRevenue',
            'months',
            'values'
        ));
    }
}