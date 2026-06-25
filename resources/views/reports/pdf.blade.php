<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório {{ $monthName }} {{ $year }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #1e293b; }

        .header { background: #1e3a5f; color: white; padding: 24px 32px; margin-bottom: 24px; }
        .header h1 { font-size: 22px; font-weight: bold; }
        .header p { font-size: 12px; opacity: 0.8; margin-top: 4px; }

        .body { padding: 0 32px; }

        .cards { display: table; width: 100%; margin-bottom: 24px; border-collapse: separate; border-spacing: 12px 0; }
        .card { display: table-cell; width: 33%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; background: #f8fafc; }
        .card .label { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .card .value { font-size: 18px; font-weight: bold; }
        .green { color: #16a34a; }
        .red { color: #dc2626; }
        .blue { color: #2563eb; }

        h2 { font-size: 14px; font-weight: bold; color: #1e293b; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 2px solid #e2e8f0; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        thead th { background: #f1f5f9; padding: 8px 12px; text-align: left; font-size: 10px; text-transform: uppercase; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        thead th.right { text-align: right; }
        tbody td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #334155; }
        tbody td.right { text-align: right; }
        tbody tr:last-child td { border-bottom: none; }
        tfoot td { padding: 8px 12px; font-weight: bold; font-size: 12px; background: #f8fafc; border-top: 2px solid #e2e8f0; }
        tfoot td.right { text-align: right; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-amber { background: #fef9c3; color: #854d0e; }

        .footer { margin-top: 32px; padding: 16px 32px; border-top: 1px solid #e2e8f0; text-align: center; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>

<div class="header">
    <h1>NotaPronta — Relatório Mensal</h1>
    <p>{{ ucfirst($monthName) }} de {{ $year }} · Gerado em {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="body">

    {{-- Cards de resumo --}}
    <div class="cards">
        <div class="card">
            <div class="label">Faturamento</div>
            <div class="value green">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Despesas</div>
            <div class="value red">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Lucro estimado</div>
            <div class="value {{ $totalProfit >= 0 ? 'blue' : 'red' }}">R$ {{ number_format($totalProfit, 2, ',', '.') }}</div>
        </div>
    </div>

    {{-- Vendas --}}
    <h2>Vendas do período</h2>
    @if($sales->isEmpty())
        <p style="color: #94a3b8; margin-bottom: 24px;">Nenhuma venda registrada neste período.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Pagamento</th>
                    <th class="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>
                        <span class="badge {{ $sale->payment_type === 'a_vista' ? 'badge-green' : 'badge-amber' }}">
                            {{ $sale->payment_type === 'a_vista' ? 'À vista' : 'A prazo' }}
                        </span>
                    </td>
                    <td class="right" style="color: #16a34a; font-weight: bold;">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total de vendas</td>
                    <td class="right" style="color: #16a34a;">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- Despesas --}}
    <h2>Despesas do período</h2>
    @if($expenses->isEmpty())
        <p style="color: #94a3b8; margin-bottom: 24px;">Nenhuma despesa registrada neste período.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th class="right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td class="right" style="color: #dc2626; font-weight: bold;">R$ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total de despesas</td>
                    <td class="right" style="color: #dc2626;">R$ {{ number_format($totalExpenses, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif

</div>

<div class="footer">
    NotaPronta · Relatório gerado automaticamente · {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>