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

    <hr>
<h5>Return Product</h5>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('client.invoice.return', $invoice->id) }}">
    @csrf

    <div class="mb-2">
        <label>Select Product to Return</label>
        <select name="product_id" class="form-select">
            @foreach($invoice->items as $item)
                @if($item->qty > 0) {{-- Only allow returning purchased items --}}
                    <option value="{{ $item->product->id }}">
                        {{ $item->product->name }} (Purchased: {{ $item->qty }})
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label>Quantity to Return</label>
        <input type="number" name="qty" class="form-control" min="1" value="1">
    </div>

    <button type="submit" class="btn btn-danger">Return Product</button>
</form>


    <a href="{{ route('client.invoice.report') }}" class="btn btn-secondary">
        Back
    </a>
</div>
@endsection
