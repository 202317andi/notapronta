<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotaPronta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
            NotaPronta
        </a>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:underline">
                    Sair
                </button>
            </form>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-56 min-h-screen bg-white shadow p-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Dashboard
            </a>
            <a href="{{ route('categories.index') }}"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Categorias
            </a>
            <a href="#"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Produtos
            </a>
            <a href="#"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Clientes
            </a>
            <a href="#"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Despesas
            </a>
            <a href="#"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Orçamentos
            </a>
            <a href="#"
               class="block px-3 py-2 rounded hover:bg-indigo-50 text-gray-700 text-sm">
                Vendas
            </a>
        </aside>

        <!-- Conteúdo -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>