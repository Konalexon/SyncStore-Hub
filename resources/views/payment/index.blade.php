@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold py-3">
                        <i class="bi bi-credit-card me-2"></i> Secure Payment
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">${{ number_format($total, 2) }}</h3>
                            <p class="text-muted">Total Amount</p>
                        </div>

                        <form action="{{ route('payment.process') }}" method="POST" id="paymentForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Cardholder Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control border-start-0" placeholder="John Doe" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" class="form-control border-start-0" placeholder="0000 0000 0000 0000"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CVC</label>
                                    <input type="text" class="form-control" placeholder="123" required>
                                </div>
                            </div>

                            <div class="alert alert-info small">
                                <i class="bi bi-info-circle me-1"></i> This is a mock payment gateway. No real money will be
                                charged.
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                Pay Now <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection