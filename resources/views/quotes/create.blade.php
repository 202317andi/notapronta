@extends('layouts.admin')

@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Orçamento</h1>

    @if($customers->isEmpty() || $products->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 text-sm">
            ⚠️ Você precisa cadastrar pelo menos um cliente e um produto antes.
        </div>
    @endif

    <div class="bg-white rounded shadow p-6">
        <form method="POST" action="{{ route('quotes.store') }}" id="quote-form">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
                <select name="customer_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">Selecione...</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('customer_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="notes" rows="2" class="w-full border rounded px-3 py-2 text-sm"></textarea>
            </div>

            <hr class="my-4">

            <h3 class="font-bold text-gray-700 mb-3">Itens do Orçamento</h3>

            <div id="items-container"></div>

            <button type="button" onclick="addItem()"
                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 mb-4">
                + Adicionar Item
            </button>

            @error('items')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

            <div class="flex gap-2 mt-6">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                    Salvar Orçamento
                </button>
                <a href="{{ route('quotes.index') }}"
                   class="px-4 py-2 rounded border text-sm text-gray-600 hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const products = @json($products);
let itemIndex = 0;

function addItem() {
    const container = document.getElementById('items-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-2 items-center';
    div.innerHTML = `
        <select name="items[${itemIndex}][product_id]" class="flex-1 border rounded px-2 py-1 text-sm">
            <option value="">Produto...</option>
            ${products.map(p => `<option value="${p.id}">${p.name} - R$ ${parseFloat(p.price).toFixed(2)}</option>`).join('')}
        </select>
        <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1"
               class="w-20 border rounded px-2 py-1 text-sm" placeholder="Qtd">
        <button type="button" onclick="this.parentElement.remove()"
                class="text-red-500 text-sm">Remover</button>
    `;
    container.appendChild(div);
    itemIndex++;
}

// Adiciona um item inicial automaticamente
addItem();
</script>
@endsection