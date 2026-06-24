<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::where('user_id', auth()->id())
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $customers = Customer::where('user_id', auth()->id())->orderBy('name')->get();
        $products = Product::where('user_id', auth()->id())->orderBy('name')->get();
        return view('quotes.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'notes' => 'nullable|string',
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

        $quote = Quote::create([
            'user_id' => auth()->id(),
            'customer_id' => $request->customer_id,
            'public_token' => Str::uuid(),
            'status' => 'rascunho',
            'total' => $total,
            'notes' => $request->notes,
        ]);

        foreach ($itemsData as $item) {
            $quote->items()->create($item);
        }

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Orçamento criado com sucesso!');
    }

    public function show(Quote $quote)
    {
        abort_if($quote->user_id !== auth()->id(), 403);
        $quote->load('customer', 'items.product');
        return view('quotes.show', compact('quote'));
    }

    public function destroy(Quote $quote)
    {
        abort_if($quote->user_id !== auth()->id(), 403);
        $quote->delete();

        return redirect()->route('quotes.index')
            ->with('success', 'Orçamento excluído!');
    }

    public function send(Quote $quote)
    {
        abort_if($quote->user_id !== auth()->id(), 403);
        $quote->update([
            'status' => 'enviado',
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Orçamento marcado como enviado!');
    }
}