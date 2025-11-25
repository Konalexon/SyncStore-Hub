@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Checkout</h2>
        <p class="text-muted">Complete your purchase securely.</p>
    </div>

    <form action="{{ route('payment.process') }}" method="POST" id="paymentForm">
        @csrf
        <div class="row g-5">
            <!-- Left Column: Payment Details -->
            <div class="col-lg-8">
                <!-- Payment Methods -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Payment Method</h5>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="method_card" value="card" checked>
                                <label class="btn btn-outline-light text-dark border w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2 h-100 justify-content-center" for="method_card">
                                    <i class="bi bi-credit-card-2-front fs-3 text-primary"></i>
                                    <span class="small fw-bold">Card</span>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="method_blik" value="blik">
                                <label class="btn btn-outline-light text-dark border w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2 h-100 justify-content-center" for="method_blik">
                                    <span class="fs-3 fw-bold text-dark" style="line-height: 1;">BLIK</span>
                                    <span class="small fw-bold">BLIK</span>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="method_paypal" value="paypal">
                                <label class="btn btn-outline-light text-dark border w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2 h-100 justify-content-center" for="method_paypal">
                                    <i class="bi bi-paypal fs-3 text-primary"></i>
                                    <span class="small fw-bold">PayPal</span>
                                </label>
                            </div>
                            <div class="col-md-3 col-6">
                                <input type="radio" class="btn-check" name="payment_method" id="method_gpay" value="gpay">
                                <label class="btn btn-outline-light text-dark border w-100 py-3 rounded-3 d-flex flex-column align-items-center gap-2 h-100 justify-content-center" for="method_gpay">
                                    <i class="bi bi-google fs-3 text-danger"></i>
                                    <span class="small fw-bold">Google Pay</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Payment Details</h5>
                        
                        <!-- Card Details -->
                        <div id="card-details">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="cardName" placeholder="John Doe" required>
                                <label for="cardName">Cardholder Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="cardNumber" placeholder="0000 0000 0000 0000" required>
                                <label for="cardNumber">Card Number</label>
                            </div>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                                        <label for="expiryDate">Expiry</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="cvc" placeholder="123" required>
                                        <label for="cvc">CVC</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BLIK Details -->
                        <div id="blik-details" class="d-none text-center py-4">
                            <div class="form-floating w-50 mx-auto">
                                <input type="text" class="form-control text-center fs-3 letter-spacing-2 fw-bold" id="blikCode" placeholder="000 000" maxlength="6">
                                <label for="blikCode" class="text-center w-100">BLIK Code</label>
                            </div>
                            <p class="text-muted small mt-3">Open your banking app to generate the code.</p>
                        </div>

                        <!-- PayPal/GPay Details -->
                        <div id="redirect-details" class="d-none text-center py-4">
                            <i class="bi bi-box-arrow-up-right fs-1 text-primary mb-3"></i>
                            <p class="mb-0">You will be redirected to complete your payment securely.</p>
                        </div>

                        <div class="alert alert-light border d-flex align-items-center mt-4 mb-0" role="alert">
                            <i class="bi bi-shield-lock-fill fs-4 me-3 text-success"></i>
                            <div class="small text-muted">
                                Your payment information is encrypted and secure. We do not store your card details.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        
                        <!-- Product List -->
                        <div class="mb-4">
                            @foreach(session('cart') as $id => $details)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="position-relative me-3">
                                        <img src="{{ $details['image'] }}" class="rounded-3 object-fit-cover" width="60" height="60">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary small">
                                            {{ $details['quantity'] }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold small">{{ $details['name'] }}</h6>
                                        <small class="text-muted">${{ number_format($details['price'], 2) }}</small>
                                    </div>
                                    <div class="fw-bold small">
                                        ${{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="border-secondary-subtle">

                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Shipping</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 text-muted">
                            <span>Tax</span>
                            <span>$0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-4 text-primary">${{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm hover-scale">
                            Pay ${{ number_format($total, 2) }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="module">
    const methodRadios = document.querySelectorAll('input[name="payment_method"]');
    const cardDetails = document.getElementById('card-details');
    const blikDetails = document.getElementById('blik-details');
    const redirectDetails = document.getElementById('redirect-details');

    methodRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            // Hide all first
            cardDetails.classList.add('d-none');
            blikDetails.classList.add('d-none');
            redirectDetails.classList.add('d-none');

            if (e.target.value === 'card') {
                cardDetails.classList.remove('d-none');
            } else if (e.target.value === 'blik') {
                blikDetails.classList.remove('d-none');
            } else {
                redirectDetails.classList.remove('d-none');
            }
        });
    });
</script>

<style>
    .letter-spacing-2 {
        letter-spacing: 0.2em;
    }
    .btn-check:checked + .btn {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-2px);
    }
</style>
@endsection