<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Mês e ano atual por padrão
        $month = request('month', now()->month);
        $year  = request('year', now()->year);

        // Vendas do período
        $sales = Sale::where('user_id', $userId)
            ->whereYear('sale_date', $year)
            ->whereMonth('sale_date', $month)
            ->with('customer', 'items.product')
            ->orderBy('sale_date')
            ->get();

        // Despesas do período
        $expenses = Expense::where('user_id', $userId)
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->orderBy('expense_date')
            ->get();

        // Totais
        $totalRevenue  = $sales->sum('total');
        $totalExpenses = $expenses->sum('amount');
        $totalProfit   = $totalRevenue - $totalExpenses;

        // Orçamentos aceitos no período
        $quotesAccepted = Quote::where('user_id', $userId)
            ->where('status', 'aceito')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        return view('reports.index', compact(
            'sales',
            'expenses',
            'totalRevenue',
            'totalExpenses',
            'totalProfit',
            'quotesAccepted',
            'month',
            'year'
        ));
    }

    public function pdf(Request $request)
    {
        $userId = auth()->id();

        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $sales = Sale::where('user_id', $userId)
            ->whereYear('sale_date', $year)
            ->whereMonth('sale_date', $month)
            ->with('customer', 'items.product')
            ->orderBy('sale_date')
            ->get();

        $expenses = Expense::where('user_id', $userId)
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->orderBy('expense_date')
            ->get();

        $totalRevenue  = $sales->sum('total');
        $totalExpenses = $expenses->sum('amount');
        $totalProfit   = $totalRevenue - $totalExpenses;

        // Nome do mês em português
        $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)
            ->locale('pt_BR')
            ->isoFormat('MMMM');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'sales',
            'expenses',
            'totalRevenue',
            'totalExpenses',
            'totalProfit',
            'month',
            'year',
            'monthName'
        ))->setPaper('a4');

        return $pdf->download("relatorio-{$monthName}-{$year}.pdf");
    }
}