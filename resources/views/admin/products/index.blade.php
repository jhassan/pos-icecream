@extends('layouts.app')
@section('title','Products')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Products</span>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">Add Product</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>#</th><th>Name</th><th>Category</th><th>Sale Price</th><th>Purchase Price</th><th>Stock</th><th>Actions</th>
            </tr>
            @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->sale_price }}</td>
                <td>{{ $product->purchase_price }}</td>
                <td>{{ $product->stock_quantity }}</td>
                <td>
                    <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
