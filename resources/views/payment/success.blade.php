@extends('layouts.app')

@section('content')
    <div class="container py-5 text-center">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body p-5">
                <div class="mb-4 text-success">
                    <i class="bi bi-check-circle-fill display-1"></i>
                </div>
                <h2 class="fw-bold mb-3">Payment Successful!</h2>
                <p class="text-muted mb-4">Thank you for your purchase. Your order has been placed successfully.</p>

                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.orders') }}" class="btn btn-primary">View My Orders</a>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
@endsection