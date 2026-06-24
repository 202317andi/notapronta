<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', auth()->id())
            ->orderBy('expense_date', 'desc')
            ->get();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'user_id'      => auth()->id(),
            'description'  => $request->description,
            'amount'       => $request->amount,
            'expense_date' => $request->expense_date,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Despesa cadastrada com sucesso!');
    }

    public function edit(Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);

        $request->validate([
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($request->only('description', 'amount', 'expense_date'));

        return redirect()->route('expenses.index')
            ->with('success', 'Despesa atualizada com sucesso!');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->user_id !== auth()->id(), 403);
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Despesa excluída com sucesso!');
    }
}