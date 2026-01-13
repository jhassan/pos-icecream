@extends('layouts.client.app')

@section('content')
<div class="container">
    <h3>Invoice #{{ $invoice->id }}</h3>

    <p>
        <strong>Date:</strong>
        {{ $invoice->created_at->format('d-m-Y') }}
    </p>

    <p>
        <strong>Total:</strong>
        {{ number_format($invoice->total, 2) }}
    </p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('client.invoice.report') }}" class="btn btn-secondary">
        Back
    </a>
</div>
@endsection
