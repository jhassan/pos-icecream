<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #000;
        }
        .invoice-box {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
        }
        h2, h4 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background: #f5f5f5;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

<div class="invoice-box">

    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
        <div>
            <h2>INVOICE</h2>
            <p>
                <strong>Invoice #:</strong> {{ $invoice->id }}<br>
                <strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}
            </p>
        </div>

        <div>
            <h4>Client</h4>
            <p>
                {{ $invoice->client->name ?? 'N/A' }}<br>
                {{ $invoice->client->email ?? '' }}
            </p>
        </div>
    </div>

    {{-- Items --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">Rs {{ number_format($item->price, 2) }}</td>
                    <td class="text-right">
                        Rs {{ number_format($item->subtotal, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Grand Total</td>
                <td class="text-right">
                    Rs {{ number_format($invoice->total, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Footer --}}
    <div style="margin-top:30px; text-align:center;">
        <p>Thank you for your business!</p>
    </div>

    <div class="no-print" style="margin-top:20px; text-align:center;">
        <button onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
