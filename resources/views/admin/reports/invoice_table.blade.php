<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Invoice #</th>
            <th>Client</th>
            <th>Category</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reportData as $row)
            <tr>
                <td>{{ $row->invoice->created_at->format('d-m-Y') }}</td>
                <td>#{{ $row->invoice_id }}</td>
                <td>{{ $row->invoice->client->name ?? '-' }}</td>
                <td>{{ $row->product->category->name ?? '-' }}</td>
                <td>{{ $row->product->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->price,2) }}</td>
                <td>{{ number_format($row->subtotal,2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No records found</td>
            </tr>
        @endforelse
    </tbody>
    @if($reportData->count())
    <tfoot>
        <tr>
            <th colspan="7" class="text-end">Total</th>
            <th>{{ number_format($totalSubtotal, 2) }}</th>
        </tr>
    </tfoot>
    @endif
</table>

{{ $reportData->withQueryString()->links() }}
