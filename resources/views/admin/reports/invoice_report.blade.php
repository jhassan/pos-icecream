@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Filters --}}
    <form id="filterForm" class="row g-3 mb-3">
        <div class="col-md-2">
            <input type="date" class="form-control" name="from_date" value="{{ $from_date ?? '' }}">

        </div>
        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control" value="{{ $to_date ?? '' }}">

        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="product_id" class="form-control">
                <option value="">All Products</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}" @selected(request('product_id')==$prod->id)>
                        {{ $prod->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="client_id" class="form-control">
                <option value="">All Clients</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected(request('client_id')==$client->id)>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" id="filterBtn" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div id="reportTable">
        @include('admin.reports.invoice_table', ['reportData' => $reportData])
    </div>

</div>
@endsection
