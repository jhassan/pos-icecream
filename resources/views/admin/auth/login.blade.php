@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">

        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="mb-0">Admin Login</h5>
            </div>

            <div class="card-body">

                {{-- ❌ Global Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter email"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter password"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">
                            Login
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
