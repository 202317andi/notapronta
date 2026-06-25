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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Orçamento público (cliente acessa via link sem login)
Route::get('/orcamento/{token}', [PublicQuoteController::class, 'show'])->name('public.quote');
Route::post('/orcamento/{token}/aceitar', [PublicQuoteController::class, 'accept'])->name('public.quote.accept');
Route::post('/orcamento/{token}/recusar', [PublicQuoteController::class, 'reject'])->name('public.quote.reject');

// Área administrativa (requer login)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categorias
    Route::resource('categories', CategoryController::class);

    // Clientes
    Route::resource('customers', CustomerController::class);

    // Produtos
    Route::resource('products', ProductController::class);

    // Despesas
    Route::resource('expenses', ExpenseController::class);

    // Orçamentos (sem edição — orçamento criado é imutável)
    Route::resource('quotes', QuoteController::class)->except(['edit', 'update']);
    Route::post('/quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');

    // Vendas (sem edição — venda registrada é imutável)
    Route::resource('sales', SaleController::class)->except(['edit', 'update']);

    // Relatórios
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');

    // Documentação da API
    Route::get('/api-docs', function () {
        return view('api-docs');
    })->name('api.docs');

    // API JSON
    Route::prefix('api')->group(function () {
        Route::get('/products', [ApiController::class, 'products']);
        Route::get('/customers', [ApiController::class, 'customers']);
        Route::get('/quotes', [ApiController::class, 'quotes']);
        Route::get('/stats', [ApiController::class, 'stats']);
    });

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';