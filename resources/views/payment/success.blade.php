@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle"
                    style="width: 100px; height: 100px;">
                    <i class="bi bi-check-lg display-3"></i>
                </div>
            </div>
            <h1 class="fw-bold mb-3">Payment Successful!</h1>
            <p class="text-muted lead mb-5">Thank you for your purchase. Your order has been confirmed.</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4 rounded-pill">View Order</a>
                <a href="/" class="btn btn-primary px-4 rounded-pill">Continue Shopping</a>
            </div>
        </div>
    </div>
@endsection