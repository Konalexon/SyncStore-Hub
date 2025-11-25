@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white p-4 text-center">
                        <h4 class="mb-0 fw-bold">Secure Checkout</h4>
                        <p class="mb-0 opacity-75">Complete your purchase</p>
                    </div>
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="display-4 fw-bold text-primary">${{ number_format($total, 2) }}</h1>
                            <p class="text-muted">Total Amount</p>
                        </div>

                        <form action="{{ route('payment.process') }}" method="POST" id="paymentForm">
                            @csrf

                            <!-- Simulated Card Form -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Card Information</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000"
                                        maxlength="19">
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="MM/YY">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="CVC">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold position-relative"
                                    id="payBtn">
                                    <span id="btnText">Pay Now</span>
                                    <div id="spinner"
                                        class="spinner-border spinner-border-sm text-white position-absolute top-50 start-50 translate-middle d-none"
                                        role="status"></div>
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted"><i class="bi bi-lock-fill me-1"></i> Payments are secure and
                                    encrypted</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function (e) {
            const btn = document.getElementById('payBtn');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');

            btn.disabled = true;
            text.classList.add('opacity-0');
            spinner.classList.remove('d-none');
        });
    </script>
@endsection