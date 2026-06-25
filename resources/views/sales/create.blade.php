@extends('layouts.admin')

@section('content')

<div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
    <a href="{{ route('sales.index') }}" class="hover:text-blue-600">Vendas</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
    </svg>
    <span class="text-slate-700">Nova venda</span>
</div>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Nova venda</h1>
    <p class="text-sm text-slate-500 mt-1">Registre uma venda realizada.</p>
</div>

<div class="max-w-3xl">
    <form method="POST" action="{{ route('sales.store') }}">
        @csrf

        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Cliente <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id"
                            class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">Selecione...</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Data da venda <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="sale_date" value="{{ date('Y-m-d') }}"
                           class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Forma de pagamento <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    <label class="flex-1 flex items-center gap-3 p-3 border border-slate-300 rounded-lg cursor-pointer hover:border-blue-400 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="radio" name="payment_type" value="a_vista" checked class="text-blue-600">
                        <div>
                            <div class="text-sm font-medium text-slate-900">À vista</div>
                            <div class="text-xs text-slate-500">Pagamento imediato</div>
                        </div>
                    </label>
                    <label class="flex-1 flex items-center gap-3 p-3 border border-slate-300 rounded-lg cursor-pointer hover:border-blue-400 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="radio" name="payment_type" value="a_prazo" class="text-blue-600">
                        <div>
                            <div class="text-sm font-medium text-slate-900">A prazo</div>
                            <div class="text-xs text-slate-500">Parcelado ou fiado</div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        {{-- Itens --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-900">Itens da venda</h3>
                <button type="button" onclick="addItem()"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Adicionar item
                </button>
            </div>

            <div id="items-container" class="space-y-2"></div>

            @error('items')<p class="text-red-600 text-xs mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                Registrar venda
            </button>
            <a href="{{ route('sales.index') }}"
               class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
const products = @json($products);
let itemIndex = 0;

function addItem() {
    const container = document.getElementById('items-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 items-center bg-slate-50 rounded-lg p-3';
    div.innerHTML = `
        <select name="items[${itemIndex}][product_id]"
                class="flex-1 px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Selecione o produto...</option>
            ${products.map(p => `<option value="${p.id}">${p.name} — R$ ${parseFloat(p.price).toLocaleString('pt-BR', {minimumFractionDigits:2})}</option>`).join('')}
        </select>
        <div class="flex items-center gap-1">
            <label class="text-xs text-slate-500 whitespace-nowrap">Qtd</label>
            <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1"
                   class="w-16 px-2 py-2 border border-slate-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="button" onclick="this.closest('div').remove()"
                class="text-slate-400 hover:text-red-500 transition p-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    container.appendChild(div);
    itemIndex++;
}

addItem();
</script>

@endsection