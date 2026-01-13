@extends('layouts.app')
@section('title','Edit Product')
@section('content')

<div class="card">
    <div class="card-header">Edit Product</div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Size</label>
                <input type="text" name="size" value="{{ old('size', $product->size) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Sale Price</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Purchase Price</label>
                <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Stock Quantity</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <button class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

@endsection
