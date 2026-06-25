<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotaPronta — Gestão simples pra pequenos negócios</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-900 font-sans antialiased">

{{-- ========================================
     HEADER
     ======================================== --}}
<header class="border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <div class="bg-blue-600 w-9 h-9 rounded-lg flex items-center justify-center font-bold text-white">
                N
            </div>
            <span class="font-bold text-slate-900">NotaPronta</span>
        </a>

        <nav class="flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Acessar Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 transition">
                    Entrar
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Cadastrar grátis
                </a>
            @endauth
        </nav>
    </div>
</header>

{{-- ========================================
     HERO (chamada principal)
     ======================================== --}}
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
    <div class="max-w-5xl mx-auto px-6 py-20 text-center">
        <span class="inline-block px-3 py-1 bg-blue-500/30 rounded-full text-xs font-medium mb-6">
            ✨ Gestão simples pra micro e pequenos negócios
        </span>

        <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
            Pare de fazer orçamento <br>
            <span class="text-blue-200">no caderno e no WhatsApp.</span>
        </h1>

        <p class="text-lg text-blue-100 mb-10 max-w-2xl mx-auto">
            Organize clientes, produtos, orçamentos e vendas em um só lugar.
            Envie orçamentos profissionais por link e acompanhe seu faturamento em tempo real.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @guest
                <a href="{{ route('register') }}"
                   class="px-6 py-3 bg-white text-blue-700 rounded-lg font-bold hover:bg-blue-50 transition">
                    Começar agora · grátis
                </a>
                <a href="{{ route('login') }}"
                   class="px-6 py-3 border border-blue-300 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                    Já tenho conta
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-3 bg-white text-blue-700 rounded-lg font-bold hover:bg-blue-50 transition">
                    Ir para o Dashboard
                </a>
            @endguest
        </div>
    </div>
</section>

{{-- ========================================
     FUNCIONALIDADES (4 cards)
     ======================================== --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-3">Tudo que você precisa</h2>
            <p class="text-slate-500">Recursos pensados pra quem toca o próprio negócio</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Feature 1 --}}
            <div class="p-6 rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-lg transition">
                <div class="bg-blue-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Orçamentos profissionais</h3>
                <p class="text-sm text-slate-600">
                    Crie orçamentos em segundos e envie para o cliente por um link único.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="p-6 rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-lg transition">
                <div class="bg-green-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Acompanhe seu lucro</h3>
                <p class="text-sm text-slate-600">
                    Dashboard com gráficos mostra receita, despesas e lucro mensal.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="p-6 rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-lg transition">
                <div class="bg-purple-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Clientes organizados</h3>
                <p class="text-sm text-slate-600">
                    Tenha todo o histórico de compras de cada cliente em um só lugar.
                </p>
            </div>

            {{-- Feature 4 --}}
            <div class="p-6 rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-lg transition">
                <div class="bg-amber-50 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">API JSON</h3>
                <p class="text-sm text-slate-600">
                    Integre seus dados com outros sistemas e ferramentas.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ========================================
     COMO FUNCIONA (3 passos)
     ======================================== --}}
<section class="bg-slate-50 py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-3">Como funciona</h2>
            <p class="text-slate-500">Em 3 passos você já tá usando</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-4">1</div>
                <h3 class="font-bold text-slate-900 mb-2">Cadastre seu catálogo</h3>
                <p class="text-sm text-slate-600">
                    Crie suas categorias, produtos ou serviços com preço.
                </p>
            </div>

            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-4">2</div>
                <h3 class="font-bold text-slate-900 mb-2">Monte um orçamento</h3>
                <p class="text-sm text-slate-600">
                    Adicione itens, escolha o cliente e gere um link único.
                </p>
            </div>

            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-4">3</div>
                <h3 class="font-bold text-slate-900 mb-2">Envie pro cliente</h3>
                <p class="text-sm text-slate-600">
                    Mande o link no WhatsApp. O cliente aceita com 1 clique.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ========================================
     CTA FINAL
     ======================================== --}}
<section class="py-20">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Pronto pra organizar seu negócio?</h2>
        <p class="text-slate-500 mb-8">
            Crie sua conta gratuita em menos de 1 minuto.
        </p>
        @guest
            <a href="{{ route('register') }}"
               class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                Começar agora — grátis
            </a>
        @endguest
    </div>
</section>

{{-- ========================================
     FOOTER
     ======================================== --}}
<footer class="border-t border-slate-100 py-8">
    <div class="max-w-6xl mx-auto px-6 text-center text-sm text-slate-500">
        © {{ date('Y') }} NotaPronta. Feito para micro e pequenos negócios brasileiros.
    </div>
</footer>

</body>
</html>