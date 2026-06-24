@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Produtos</h1>
    <a href="{{ route('products.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
        Novo Produto
    </a>
</div>

@if($products->isEmpty())
    <p class="text-gray-500">Nenhum produto cadastrado ainda.</p>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nome</th>
                    <th class="px-6 py-3 text-left">Categoria</th>
                    <th class="px-6 py-3 text-left">Preço</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-800">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('products.edit', $product) }}"
                           class="text-indigo-600 hover:underline">Editar</a>
                        <form method="POST"
                              action="{{ route('products.destroy', $product) }}"
                              class="inline"
                              onsubmit="return confirm('Excluir este produto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection