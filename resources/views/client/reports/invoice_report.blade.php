@extends('layouts.client.app')

@section('content')

<h4 class="mb-3">Invoice Report</h4>

{{-- 🔎 Search Form --}}
<form method="GET" action="{{ route('client.invoice.report') }}" class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="text" name="invoice_id" class="form-control" placeholder="Invoice #" value="{{ request('invoice_id') }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
    </div>
    <div class="col-md-3">
        <select name="product_id" class="form-select">
            <option value="">Select Product</option>
            @foreach(\App\Models\Product::all() as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Search</button>
        <a href="{{ route('client.invoice.report') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>
<hr>

<strong>Total Sales:</strong> {{ number_format($totalSales, 2) }} <br>
<strong>Total Quantity:</strong> {{ $totalQty }}

<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Total</th>
            <th>Items</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                <td>{{ number_format($invoice->total, 2) }}</td>
                <td>
                    @foreach($invoice->items as $item)
                        {{ $item->product->name }} ({{ $item->qty }})<br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('client.invoice.show', $invoice->id) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                    {{-- Return button --}}
                    {{-- <form method="POST" action="{{ route('client.invoice.return', $invoice->id) }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <input type="hidden" name="qty" value="1"> <!-- or allow user input -->
                        <button class="btn btn-sm btn-danger">Return</button>
                    </form> --}}

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $invoices->links() }}



@endsection
@push('scripts')
