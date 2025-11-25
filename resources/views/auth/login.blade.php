@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">Welcome Back</h3>
                            <p class="text-secondary">Sign in to continue to SyncStore Hub</p>
                        </div>

                        <form method="POST" action="{{ url('/login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
                            </div>

                            <div class="text-center">
                                <p class="text-secondary">Don't have an account? <a href="{{ url('/register') }}"
                                        class="text-primary fw-bold text-decoration-none">Sign Up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection