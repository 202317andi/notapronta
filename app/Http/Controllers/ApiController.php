<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Quote;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products()
    {
        $products = Product::where('user_id', auth()->id())
            ->with('category:id,name')
            ->get(['id', 'category_id', 'name', 'description', 'price']);

        return response()->json([
            'success' => true,
            'count' => $products->count(),
            'data' => $products,
        ]);
    }

    public function customers()
    {
        $customers = Customer::where('user_id', auth()->id())
            ->get(['id', 'name', 'email', 'phone', 'document']);

        return response()->json([
            'success' => true,
            'count' => $customers->count(),
            'data' => $customers,
        ]);
    }

    public function quotes()
    {
        $quotes = Quote::where('user_id', auth()->id())
            ->with('customer:id,name', 'items')
            ->get(['id', 'customer_id', 'status', 'total', 'created_at']);

        return response()->json([
            'success' => true,
            'count' => $quotes->count(),
            'data' => $quotes,
        ]);
    }

    public function stats()
    {
        $userId = auth()->id();

        return response()->json([
            'success' => true,
            'data' => [
                'total_customers' => Customer::where('user_id', $userId)->count(),
                'total_products' => Product::where('user_id', $userId)->count(),
                'total_quotes' => Quote::where('user_id', $userId)->count(),
                'total_revenue' => (float) Quote::where('user_id', $userId)
                    ->where('status', 'aceito')
                    ->sum('total'),
                'quotes_by_status' => [
                    'rascunho' => Quote::where('user_id', $userId)->where('status', 'rascunho')->count(),
                    'enviado' => Quote::where('user_id', $userId)->where('status', 'enviado')->count(),
                    'aceito' => Quote::where('user_id', $userId)->where('status', 'aceito')->count(),
                    'recusado' => Quote::where('user_id', $userId)->where('status', 'recusado')->count(),
                ],
            ],
        ]);
    }
}