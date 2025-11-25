@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Admin Dashboard</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card bg-primary text-white border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-white-50">Total Products</h6>
                        <h2 class="fw-bold display-6">{{ $stats['products'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-white-50">Total Revenue</h6>
                        <h2 class="fw-bold display-6">${{ number_format($stats['revenue'], 2) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-white-50">Active Users</h6>
                        <h2 class="fw-bold display-6">{{ $stats['users'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-dark-50">Total Orders</h6>
                        <h2 class="fw-bold display-6">{{ $stats['orders'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Quick Actions</h5>
                        <div class="d-grid gap-3">
                            <a href="{{ url('/admin/products') }}" class="btn btn-outline-primary btn-lg text-start">
                                <i class="bi bi-box-seam me-2"></i> Manage Products
                            </a>
                            <a href="{{ url('/admin/live') }}" class="btn btn-outline-danger btn-lg text-start">
                                <i class="bi bi-camera-video me-2"></i> Control Live Stream
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection