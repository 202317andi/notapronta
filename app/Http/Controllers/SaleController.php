<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::where('user_id', auth()->id())
            ->with('customer')
            ->orderBy('sale_date', 'desc')
            ->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::where('user_id', auth()->id())->orderBy('name')->get();
        $products = Product::where('user_id', auth()->id())->orderBy('name')->get();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_type' => 'required|in:a_vista,a_prazo',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;
        $itemsData = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            $itemsData[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $subtotal,
            ];
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'customer_id' => $request->customer_id,
            'total' => $total,
            'payment_type' => $request->payment_type,
            'sale_date' => $request->sale_date,
        ]);

        foreach ($itemsData as $item) {
            $sale->items()->create($item);
        }

        return redirect()->route('sales.index')
            ->with('success', 'Venda registrada com sucesso!');
    }

    public function show(Sale $sale)
    {
        abort_if($sale->user_id !== auth()->id(), 403);
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        abort_if($sale->user_id !== auth()->id(), 403);
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Venda excluída!');
    }
}