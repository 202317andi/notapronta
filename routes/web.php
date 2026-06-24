<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\PublicQuoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orcamento/{token}', [PublicQuoteController::class, 'show'])->name('public.quote');
Route::post('/orcamento/{token}/aceitar', [PublicQuoteController::class, 'accept'])->name('public.quote.accept');
Route::post('/orcamento/{token}/recusar', [PublicQuoteController::class, 'reject'])->name('public.quote.reject');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('expenses', ExpenseController::class);

    Route::get('/api-docs', function () {
        return view('api-docs');
    })->name('api.docs');

    Route::resource('quotes', QuoteController::class)->except(['edit', 'update']);
    Route::post('/quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');

    Route::resource('sales', \App\Http\Controllers\SaleController::class)->except(['edit', 'update']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('api')->group(function () {
        Route::get('/products', [ApiController::class, 'products']);
        Route::get('/customers', [ApiController::class, 'customers']);
        Route::get('/quotes', [ApiController::class, 'quotes']);
        Route::get('/stats', [ApiController::class, 'stats']);
    });
});

require __DIR__.'/auth.php';