@extends('layouts.app')
@section('title','Add Product')

@section('content')
<div class="card">
    <div class="card-header">Add Product</div>
    <div class="card-body">

        {{-- Show all validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf

            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Product name"
                   class="form-control mb-2 @error('name') is-invalid @enderror">

            <select name="category_id"
                    class="form-control mb-2 @error('category_id') is-invalid @enderror">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <input type="text"
                   name="size"
                   value="{{ old('size') }}"
                   placeholder="Size"
                   class="form-control mb-2">

            <input type="number"
                   name="sale_price"
                   value="{{ old('sale_price') }}"
                   placeholder="Sale Price"
                   class="form-control mb-2 @error('sale_price') is-invalid @enderror">

            <textarea name="description"
                      placeholder="Description"
                      class="form-control mb-2">{{ old('description') }}</textarea>

            <button class="btn btn-success">Save</button>
        </form>

    </div>
</div>
@endsection
