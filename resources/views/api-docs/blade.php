@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">API JSON</h1>
    <p class="text-gray-500 mb-6">
        Endpoints disponíveis para integração com outros sistemas. Clique para testar.
    </p>

    <div class="space-y-4">
        <!-- Endpoint Products -->
        <div class="bg-white rounded shadow p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">GET</span>
                    <code class="text-sm ml-2">/api/products</code>
                </div>
                <a href="{{ url('/api/products') }}" target="_blank"
                   class="text-indigo-600 text-sm hover:underline">Testar →</a>
            </div>
            <p class="text-sm text-gray-600">Lista todos os produtos do usuário logado.</p>
        </div>

        <!-- Endpoint Customers -->
        <div class="bg-white rounded shadow p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">GET</span>
                    <code class="text-sm ml-2">/api/customers</code>
                </div>
                <a href="{{ url('/api/customers') }}" target="_blank"
                   class="text-indigo-600 text-sm hover:underline">Testar →</a>
            </div>
            <p class="text-sm text-gray-600">Lista todos os clientes do usuário logado.</p>
        </div>

        <!-- Endpoint Quotes -->
        <div class="bg-white rounded shadow p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">GET</span>
                    <code class="text-sm ml-2">/api/quotes</code>
                </div>
                <a href="{{ url('/api/quotes') }}" target="_blank"
                   class="text-indigo-600 text-sm hover:underline">Testar →</a>
            </div>
            <p class="text-sm text-gray-600">Lista todos os orçamentos com seus itens.</p>
        </div>

        <!-- Endpoint Stats -->
        <div class="bg-white rounded shadow p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">GET</span>
                    <code class="text-sm ml-2">/api/stats</code>
                </div>
                <a href="{{ url('/api/stats') }}" target="_blank"
                   class="text-indigo-600 text-sm hover:underline">Testar →</a>
            </div>
            <p class="text-sm text-gray-600">Estatísticas gerais (clientes, produtos, faturamento, etc).</p>
        </div>
    </div>

    <div class="mt-8 bg-indigo-50 rounded p-4 text-sm">
        <strong>💡 Como integrar com outros sistemas:</strong>
        <p class="text-gray-700 mt-2">
            Esses endpoints retornam JSON e podem ser consumidos por aplicativos mobile,
            sistemas de contabilidade externos, integrações com ERPs, etc.
        </p>
    </div>
</div>
@endsection