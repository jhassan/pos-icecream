@extends('layouts.app')
@section('title','Add Product')
@section('content')
<div class="card">
    <div class="card-header">Add Product</div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Product name" class="form-control mb-2">
            <select name="category_id" class="form-control mb-2">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <input type="text" name="size" placeholder="Size" class="form-control mb-2">
            <input type="number" name="sale_price" placeholder="Sale Price" class="form-control mb-2">
            <input type="number" name="purchase_price" placeholder="Purchase Price" class="form-control mb-2">
            <input type="number" name="stock_quantity" placeholder="Stock" class="form-control mb-2">
            <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
            <button class="btn btn-success">Save</button>
        </form>

    </div>
</div>
@endsection
