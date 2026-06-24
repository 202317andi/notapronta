<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class PublicQuoteController extends Controller
{
    public function show($token)
    {
        $quote = Quote::where('public_token', $token)
            ->with('customer', 'items.product', 'user')
            ->firstOrFail();

        return view('public.quote', compact('quote'));
    }

    public function accept($token)
    {
        $quote = Quote::where('public_token', $token)->firstOrFail();
        $quote->update([
            'status' => 'aceito',
            'responded_at' => now(),
        ]);

        return redirect()->route('public.quote', $token)
            ->with('success', 'Orçamento aceito! O fornecedor entrará em contato.');
    }

    public function reject($token)
    {
        $quote = Quote::where('public_token', $token)->firstOrFail();
        $quote->update([
            'status' => 'recusado',
            'responded_at' => now(),
        ]);

        return redirect()->route('public.quote', $token)
            ->with('success', 'Orçamento recusado.');
    }
}