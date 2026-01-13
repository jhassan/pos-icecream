@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Edit Category</div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
