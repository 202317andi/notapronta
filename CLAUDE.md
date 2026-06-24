# Projeto NotaPronta — Contexto pra Claude Code

## Sobre o projeto
Sistema web de controle comercial para MEIs e pequenas empresas.
Permite cadastrar produtos/serviços, clientes, gerar orçamentos com link público
para o cliente aceitar/recusar, converter orçamentos em vendas, registrar despesas,
ver dashboard com gráficos e gerar relatórios mensais. Tem também API JSON para
integrações futuras.

Este é um projeto de disciplina de faculdade. O aluno é dev junior aprendendo
Laravel — não é pra você gerar tudo pronto sem explicar. O objetivo é aprender.

## Stack técnica
- Laravel 12
- Blade puro (sem Livewire, sem Inertia)
- Breeze para autenticação (já instalado)
- MariaDB (XAMPP) — conectado como driver `mysql`
- Tailwind CSS (vem com o Breeze)
- Git/GitHub (repositório público)
- Editor: VS Code no Windows

## Estado atual do projeto
- ✅ Projeto Laravel 12 criado
- ✅ Breeze instalado (login, registro, dashboard prontos)
- ✅ Banco `notapronta` no MariaDB conectado via .env
- ✅ Migration `categories` criada e rodada com sucesso
- ✅ Model `Category` criado com `$fillable` e relacionamentos
  (`user()` belongsTo, `products()` hasMany)
- ⏳ Próximos passos: criar tabelas customers, products, expenses,
  quotes, quote_items, sales, sale_items
- ⏳ Depois: CRUDs completos (controllers, rotas, views Blade)
- ⏳ Depois: dashboard, relatórios PDF, API JSON

## Modelagem completa do banco (aprovada pelo professor)

### users (já existe, criada pelo Breeze)
Tabela padrão do Breeze. Cada user representa um empresário.

### categories
- id
- user_id (FK users, cascadeOnDelete)
- name (string)
- timestamps

### customers
- id
- user_id (FK users, cascadeOnDelete)
- name (string)
- email (string nullable)
- phone (string nullable)
- document (string nullable, CPF/CNPJ)
- timestamps

### products
- id
- user_id (FK users, cascadeOnDelete)
- category_id (FK categories, cascadeOnDelete)
- name (string)
- description (text nullable)
- price (decimal 10,2)
- timestamps

### expenses
- id
- user_id (FK users, cascadeOnDelete)
- description (string)
- amount (decimal 10,2)
- expense_date (date)
- timestamps

### quotes
- id
- user_id (FK users, cascadeOnDelete)
- customer_id (FK customers, cascadeOnDelete)
- public_token (uuid, único — usado no link público)
- status (enum: rascunho, enviado, aceito, recusado)
- total (decimal 10,2)
- notes (text nullable)
- sent_at (datetime nullable)
- responded_at (datetime nullable)
- timestamps

### quote_items
- id
- quote_id (FK quotes, cascadeOnDelete)
- product_id (FK products)
- quantity (integer)
- unit_price (decimal 10,2)
- subtotal (decimal 10,2)

### sales
- id
- user_id (FK users, cascadeOnDelete)
- customer_id (FK customers, cascadeOnDelete)
- quote_id (FK quotes, nullable — quando a venda nasce de um orçamento)
- total (decimal 10,2)
- payment_type (enum: a_vista, a_prazo)
- sale_date (date)
- timestamps

### sale_items
- id
- sale_id (FK sales, cascadeOnDelete)
- product_id (FK products)
- quantity (integer)
- unit_price (decimal 10,2)
- subtotal (decimal 10,2)

## Requisitos a cumprir (definidos pelo professor)
- Login/autenticação ✅ (Breeze)
- Área administrativa (rotas protegidas por middleware `auth`)
- Área pública (landing + página pública do orçamento via token)
- CRUDs completos
- Banco relacional
- Dashboard com gráficos (Chart.js previsto)
- Relatórios (PDF/CSV via barryvdh/laravel-dompdf)
- API JSON para consulta de produtos e vendas

## Princípios do código
- Código limpo, sem gambiarras
- Comentários só onde realmente ajudam (não comentar o óbvio)
- Seguir convenções do Laravel (Models singular PascalCase, tabelas plural snake_case)
- Sempre usar `$fillable` nos Models
- Usar `$request->validate(...)` nos Controllers; quando ficar complexo, criar Form Requests
- Rotas administrativas dentro de `Route::middleware('auth')->group(...)`
- Cada ação no CRUD = um método no Controller (index, create, store, show, edit, update, destroy)
- Usar Route Model Binding sempre que possível

## Como você (Claude Code) deve me ajudar
- **SEMPRE explique o que vai fazer ANTES de criar/editar arquivos.**
- Mostre o código antes, espere meu OK, depois aplique.
- Edite um arquivo por vez para eu acompanhar.
- Comente decisões não-óbvias.
- Eu sou dev junior aprendendo Laravel — preciso ENTENDER o código,
  não só receber pronto.
- Se eu te pedir pra gerar muita coisa de uma vez, me lembre de ir devagar.
- Não usar pacotes externos sem me consultar antes.

## Comandos úteis do projeto
```bash
# Subir o servidor
php artisan serve

# Rodar migrations
php artisan migrate

# Status das migrations
php artisan migrate:status

# Reset total do banco (CUIDADO, apaga tudo)
php artisan migrate:fresh

# Tinker (REPL)
php artisan tinker

# Criar Model + migration + controller juntos
php artisan make:model NomeModel -mc
```

## Fluxo Git
- Cada feature/CRUD termina com commit
- Mensagens em inglês no padrão: `feat:`, `fix:`, `refactor:`, `docs:`, `chore:`
- Push após cada commit