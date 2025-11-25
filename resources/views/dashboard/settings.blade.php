@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action border-0">
                                <i class="bi bi-speedometer2 me-2"></i> Overview
                            </a>
                            <a href="{{ url('/dashboard/orders') }}"
                                class="list-group-item list-group-item-action border-0">
                                <i class="bi bi-bag me-2"></i> My Orders
                            </a>
                            <a href="{{ url('/dashboard/settings') }}"
                                class="list-group-item list-group-item-action active border-0">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="list-group-item list-group-item-action border-0 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2 class="fw-bold mb-4">Account Settings</h2>

                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('dashboard.settings.update') }}" method="POST">
                            @csrf
                            <h5 class="mb-3">Personal Information</h5>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                <small class="text-muted">Email cannot be changed.</small>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Shipping Address</h5>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ $user->city }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ZIP / Postal Code</label>
                                    <input type="text" name="zip" class="form-control" value="{{ $user->zip }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ $user->country }}">
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection