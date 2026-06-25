# NotaPronta

Sistema web de controle comercial para MEIs e pequenas empresas, desenvolvido como projeto final da disciplina de Desenvolvimento Web com Laravel.

---

## Sobre o projeto

O NotaPronta nasceu de uma necessidade real que observei ao redor: muitos pequenos empreendedores ainda controlam clientes, vendas e orçamentos em cadernos, planilhas do Excel ou em conversas perdidas no WhatsApp.

A ideia foi construir um sistema simples, mas completo, que resolva isso. Um lugar onde o MEI pode cadastrar seus produtos, montar um orçamento profissional, enviar um link para o cliente responder, registrar vendas e acompanhar o financeiro do mês em um dashboard.

---

## Funcionalidades

- Autenticação completa com cadastro, login, logout e recuperação de senha
- Dashboard com cards de faturamento, despesas e lucro estimado, além de gráfico dos últimos 6 meses
- Cadastro e gerenciamento de categorias, produtos e clientes
- Criação de orçamentos com itens dinâmicos adicionados via JavaScript
- Link público do orçamento, onde o cliente abre pelo celular e aceita ou recusa sem precisar criar conta
- Registro de vendas com forma de pagamento à vista ou a prazo
- Controle de despesas mensais
- Relatório financeiro mensal com filtro por período e exportação em PDF
- API JSON com quatro endpoints para integração com outros sistemas
- Interface administrativa com sidebar, ícones e design responsivo

---

## Stack utilizada

- PHP 8.2
- Laravel 12
- Laravel Breeze para autenticação
- Blade como motor de templates
- Tailwind CSS para estilização
- MariaDB via XAMPP como banco de dados
- Chart.js para os gráficos do dashboard
- barryvdh/laravel-dompdf para geração de PDF

---

## Modelagem do banco de dados

O sistema possui nove tabelas com relacionamentos bem definidos:

```
users
  ├── categories
  ├── customers
  ├── products (pertence a category)
  ├── expenses
  ├── quotes (pertence a customer)
  │     └── quote_items (pertence a quote e product)
  └── sales (pertence a customer, pode vir de um quote)
        └── sale_items (pertence a sale e product)
```

Cada usuário é dono dos seus próprios dados. Nenhum empresário consegue ver as informações de outro, pois todas as tabelas têm um campo user_id que garante esse isolamento.

---

## Como rodar o projeto

Pré-requisitos: PHP 8.2 ou superior, Composer 2.x, Node.js 18 ou superior e XAMPP com Apache e MariaDB.

```bash
# Clonar o repositório
git clone https://github.com/seu-usuario/notapronta.git
cd notapronta

# Instalar dependências PHP
composer install

# Instalar dependências JavaScript
npm install

# Criar o arquivo de configuração
cp .env.example .env

# Gerar a chave da aplicação
php artisan key:generate
```

Abra o arquivo .env e configure o banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notapronta
DB_USERNAME=root
DB_PASSWORD=
```

Crie o banco notapronta no phpMyAdmin e rode as migrations:

```bash
php artisan migrate
```

Para subir o servidor, abra dois terminais:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Acesse em http://localhost:8000

---

## Estrutura do projeto

```
notapronta/
├── app/
│   ├── Http/Controllers/    Lógica de cada funcionalidade
│   └── Models/              Representação das tabelas do banco
├── database/
│   └── migrations/          Histórico do banco em código
├── resources/
│   └── views/               Templates Blade
│       ├── layouts/         Layout base com sidebar e header
│       ├── categories/      Telas de categorias
│       ├── customers/       Telas de clientes
│       ├── products/        Telas de produtos
│       ├── expenses/        Telas de despesas
│       ├── quotes/          Telas de orçamentos
│       ├── sales/           Telas de vendas
│       ├── reports/         Relatórios e PDF
│       └── public/          Página pública do orçamento
└── routes/
    └── web.php              Todas as rotas da aplicação
```

---

## API JSON

O sistema expõe quatro endpoints que retornam dados em formato JSON:

- GET /api/products — lista os produtos com categoria e preço
- GET /api/customers — lista os clientes cadastrados
- GET /api/quotes — lista os orçamentos com seus itens
- GET /api/stats — retorna estatísticas gerais do negócio

Todos os endpoints exigem autenticação ativa. Para integrações externas com outros sistemas, seria necessário implementar autenticação via token usando o Laravel Sanctum.

---

## O que aprendi com esse projeto

Antes de construir esse sistema, eu entendia o padrão MVC na teoria. Depois de criar cada CRUD manualmente, passando por migration, model, controller, views e rotas, o padrão ficou natural. Você começa a pensar automaticamente em qual camada cada responsabilidade pertence.

A parte mais impactante foi perceber que nunca precisei escrever SQL diretamente. O Eloquent ORM transforma objetos PHP em queries de forma transparente, com proteção contra SQL injection e conversão de tipos automática.

Aprendi também que as migrations são o controle de versão do banco de dados. Quando precisei recriar o banco do zero, foi só rodar php artisan migrate e tudo voltou exatamente como estava. Isso muda completamente a forma de pensar em projetos colaborativos.

Outro aprendizado importante foi sobre segurança. O Laravel tem várias proteções ativas por padrão que eu não conhecia: proteção contra CSRF em todos os formulários, o fillable nos models que impede preenchimento de campos sensíveis, e o escaping automático de queries que previne SQL injection.

---

## Dificuldades enfrentadas

O banco de dados foi sem dúvida o maior desafio. Em determinado momento, as migrations começaram a dar erro de tabela já existe e eu não conseguia resolver por conta das chaves estrangeiras. O MariaDB bloqueia a exclusão de tabelas quando há relacionamentos ativos. A solução foi desativar a verificação de chaves estrangeiras temporariamente antes de dropar as tabelas.

Outro problema foi um arquivo de migration que foi sobrescrito acidentalmente com o conteúdo errado. O Laravel estava criando a tabela errada com o nome certo, e demorou um tempo para perceber que o erro estava no conteúdo do arquivo e não nas configurações.

O cache do Laravel também causou confusão. Várias vezes modifiquei o .env e a mudança não tinha efeito porque a configuração estava em cache. A solução foi php artisan config:clear, mas levou um tempo para descobrir que esse era o problema.

No Windows, a diferença entre CMD e PowerShell gerou bastante confusão. Comandos como ls -la e rmdir /s /q funcionam no CMD mas não no PowerShell, que tem sua própria sintaxe. Aprendi isso na prática.

Em um momento a aplicação ficou com tela branca sem nenhum erro visível. O problema era que dois processos do Vite estavam rodando ao mesmo tempo em portas diferentes. O Laravel procurava os assets em uma porta e não encontrava porque estavam em outra.

---

## Práticas que melhoraram meu raciocínio

Commitar com frequência foi uma das lições mais valiosas. No começo eu commitava só quando terminava algo grande. Aprendi que commitar a cada etapa pequena é essencial. Quando algo quebrou, consegui voltar para um estado funcional com git reset.

Aprender a ler o erro com calma também fez diferença. O instinto inicial era tentar várias coisas aleatórias quando aparecia um problema. Com o tempo aprendi que o Laravel diz exatamente qual arquivo, qual linha e qual SQL deu problema. O diagnóstico correto economiza horas.

Seguir as convenções do framework evitou muitos problemas desnecessários. O Laravel funciona no princípio de convenção sobre configuração: se você seguir os padrões esperados, o framework resolve o resto automaticamente. Quando tentei personalizar coisas sem necessidade, só criei dificuldades.

Separar responsabilidades entre as camadas também foi um aprendizado prático. Tentei colocar lógica de negócio diretamente nas views e o código ficou ilegível rapidamente. Mover isso para o controller ou para o model deixou tudo mais limpo e fácil de manter.

---

## Observação sobre o processo de desenvolvimento

Utilizei inteligência artificial como auxiliar no desenvolvimento deste projeto. O uso não foi para gerar código pronto e colar sem entender, mas para tirar dúvidas, entender conceitos do framework, depurar erros e aprender boas práticas. Cada parte do sistema foi revisada, compreendida e testada manualmente antes de seguir em frente.

Acredito que essa é a forma mais honesta e produtiva de usar essas ferramentas no aprendizado: como um recurso de apoio, não como substituto do raciocínio próprio.

---

## Fontes e referências

As principais fontes consultadas durante o desenvolvimento foram a documentação oficial do Laravel 12 (laravel.com/docs/12.x), cobrindo migrations, Eloquent ORM, rotas, controllers e autenticação com Breeze. Para estilização foi utilizado o Tailwind CSS (tailwindcss.com/docs) e para os ícones a biblioteca Heroicons (heroicons.com). Os gráficos do dashboard foram implementados com Chart.js (chartjs.org/docs) e a geração de PDF com o pacote barryvdh/laravel-dompdf (github.com/barryvdh/laravel-dompdf). O ambiente local foi configurado com XAMPP (apachefriends.org) e o Laracasts (laracasts.com) serviu como referência complementar de boas práticas do framework.
Desenvolvido com Laravel 12, PHP 8.2, Tailwind CSS e bastante persistência.
