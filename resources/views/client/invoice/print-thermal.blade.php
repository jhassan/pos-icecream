<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>

    <style>
        /* Thermal printer styling */
        body {
            font-family: monospace;
            font-size: 12px;
            width: 80mm; /* adjust to your printer width: 58mm or 80mm */
            margin: 0;
            padding: 0;
            color: #000;
        }

        .invoice-box {
            width: 100%;
            padding: 5px;
        }

        h2, h4, h5 {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .client-info, .items, .totals {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 3px 0;
            text-align: left;
        }

        table th {
            border-bottom: 1px dashed #000;
        }

        table td {
            border-bottom: 1px dashed #eee;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            border-top: 1px dashed #000;
            font-weight: bold;
        }

        @media print {
            body {
                width: 80mm;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="invoice-box">

    {{-- Header --}}
    <h2>INVOICE</h2>
    <p style="text-align:center;">#{{ $invoice->id }}</p>

    {{-- Client Info --}}
    <div class="client-info">
        <p>
            <strong>Client:</strong> {{ $invoice->client->name ?? 'N/A' }}<br>
            <strong>Date:</strong> {{ $invoice->created_at->format('d-m-Y H:i') }}
        </p>
    </div>

    {{-- Items --}}
    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">Rs {{ number_format($item->price,2) }}</td>
                        <td class="text-right">Rs {{ number_format($item->subtotal,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Total --}}
    <div class="totals">
        <table>
            <tr class="total-row">
                <td colspan="4" class="text-right">Grand Total</td>
                <td class="text-right">Rs {{ number_format($invoice->total,2) }}</td>
            </tr>
        </table>
    </div>

    <p style="text-align:center;">Thank you for your business!</p>

    <div class="no-print" style="text-align:center; margin-top:5px;">
        <button onclick="window.print()">Print</button>
    </div>

</div>
</body>
</html>
