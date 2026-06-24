@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Clientes</h1>
    <a href="{{ route('customers.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
        Novo Cliente
    </a>
</div>

@if($customers->isEmpty())
    <p class="text-gray-500">Nenhum cliente cadastrado ainda.</p>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nome</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Telefone</th>
                    <th class="px-6 py-3 text-left">CPF/CNPJ</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($customers as $customer)
                <tr>
                    <td class="px-6 py-4 text-gray-800">{{ $customer->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $customer->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $customer->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $customer->document ?? '-' }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('customers.edit', $customer) }}"
                           class="text-indigo-600 hover:underline">Editar</a>
                        <form method="POST"
                              action="{{ route('customers.destroy', $customer) }}"
                              class="inline"
                              onsubmit="return confirm('Excluir este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection