@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">API JSON</h1>
    <p class="text-sm text-slate-500 mt-1">
        Endpoints disponíveis para integração com outros sistemas.
        Clique em "Testar" para ver a resposta em tempo real.
    </p>
</div>

<div class="space-y-4 max-w-3xl">

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">GET</span>
                <code class="text-sm font-mono text-slate-800">/api/products</code>
            </div>
            <button onclick="testar('products', this)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                Testar →
            </button>
        </div>
        <div class="px-6 pb-2 text-sm text-slate-500">Lista todos os seus produtos com categoria e preço.</div>
        <div id="result-products" class="hidden border-t border-slate-100 mx-6 mt-2 mb-4">
            <pre class="bg-slate-950 text-green-400 rounded-lg p-4 text-xs overflow-x-auto max-h-64 overflow-y-auto"></pre>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">GET</span>
                <code class="text-sm font-mono text-slate-800">/api/customers</code>
            </div>
            <button onclick="testar('customers', this)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                Testar →
            </button>
        </div>
        <div class="px-6 pb-2 text-sm text-slate-500">Lista todos os seus clientes cadastrados.</div>
        <div id="result-customers" class="hidden border-t border-slate-100 mx-6 mt-2 mb-4">
            <pre class="bg-slate-950 text-green-400 rounded-lg p-4 text-xs overflow-x-auto max-h-64 overflow-y-auto"></pre>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">GET</span>
                <code class="text-sm font-mono text-slate-800">/api/quotes</code>
            </div>
            <button onclick="testar('quotes', this)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                Testar →
            </button>
        </div>
        <div class="px-6 pb-2 text-sm text-slate-500">Lista todos os orçamentos com status e itens.</div>
        <div id="result-quotes" class="hidden border-t border-slate-100 mx-6 mt-2 mb-4">
            <pre class="bg-slate-950 text-green-400 rounded-lg p-4 text-xs overflow-x-auto max-h-64 overflow-y-auto"></pre>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">GET</span>
                <code class="text-sm font-mono text-slate-800">/api/stats</code>
            </div>
            <button onclick="testar('stats', this)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-medium hover:bg-slate-900 transition">
                Testar →
            </button>
        </div>
        <div class="px-6 pb-2 text-sm text-slate-500">Retorna estatísticas gerais do sistema.</div>
        <div id="result-stats" class="hidden border-t border-slate-100 mx-6 mt-2 mb-4">
            <pre class="bg-slate-950 text-green-400 rounded-lg p-4 text-xs overflow-x-auto max-h-64 overflow-y-auto"></pre>
        </div>
    </div>

</div>

<div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-5 max-w-3xl">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
        </svg>
        <div>
            <div class="font-semibold text-blue-900 text-sm mb-1">Como usar em outros sistemas</div>
            <p class="text-sm text-blue-800">
                Todos os endpoints retornam JSON e exigem autenticação ativa.
                Para integrações externas, seria necessário implementar tokens via Laravel Sanctum.
                Os dados são exclusivos do usuário logado — total isolamento entre contas.
            </p>
        </div>
    </div>
</div>

<script>
async function testar(endpoint, btn) {
    const resultDiv = document.getElementById(`result-${endpoint}`);
    const pre = resultDiv.querySelector('pre');

    resultDiv.classList.remove('hidden');
    pre.textContent = 'Carregando...';
    btn.textContent = 'Carregando...';
    btn.disabled = true;

    try {
        const response = await fetch(`/api/${endpoint}`);
        const data = await response.json();
        pre.textContent = JSON.stringify(data, null, 2);
        btn.textContent = 'Atualizar →';
    } catch (error) {
        pre.textContent = 'Erro: ' + error.message;
        btn.textContent = 'Testar →';
    } finally {
        btn.disabled = false;
    }
}
</script>

@endsection