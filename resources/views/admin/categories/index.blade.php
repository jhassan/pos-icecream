@extends('layouts.app')
@section('title','Categories')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Categories</span>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">Add Category</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>#</th><th>Name</th><th>Status</th><th>Actions</th>
            </tr>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit',$cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.categories.destroy',$cat->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete?');">
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
