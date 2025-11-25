@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-bold mb-0">Shopping Cart</h2>
        @if(session('cart'))
            <span class="badge bg-light text-dark ms-3 rounded-pill border cart-count-badge">{{ collect(session('cart'))->sum('quantity') }}</span>
        @else
            <span class="badge bg-light text-dark ms-3 rounded-pill border cart-count-badge">0</span>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 py-3 ps-4 text-secondary text-uppercase small fw-bold" style="width: 50%">Product</th>
                                        <th class="border-0 py-3 text-secondary text-uppercase small fw-bold" style="width: 20%">Price</th>
                                        <th class="border-0 py-3 text-secondary text-uppercase small fw-bold" style="width: 20%">Quantity</th>
                                        <th class="border-0 py-3 pe-4 text-end" style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $details)
                                        <tr data-id="{{ $id }}" class="border-bottom">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="position-relative">
                                                        <img src="{{ $details['image'] }}" width="80" height="80"
                                                            class="rounded-3 object-fit-cover shadow-sm">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $details['name'] }}</h6>
                                                        <small class="text-muted">ID: {{ $id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="fw-bold text-dark">${{ number_format($details['price'], 2) }}</span>
                                            </td>
                                            <td class="py-3">
                                                <div class="input-group input-group-sm" style="width: 100px;">
                                                    <input type="number" value="{{ $details['quantity'] }}" min="1"
                                                        class="form-control text-center fw-bold border-secondary-subtle quantity update-cart">
                                                </div>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <button class="btn btn-link text-danger p-0 remove-from-cart" title="Remove">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <a href="{{ url('/catalog') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 1;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Subtotal</span>
                            <span class="cart-total-display">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Shipping</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 text-muted">
                            <span>Tax (Estimated)</span>
                            <span>$0.00</span>
                        </div>
                        
                        <hr class="border-secondary-subtle">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5 text-primary cart-total-display">${{ number_format($total, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm hover-scale">
                            Proceed to Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="mt-4 d-flex justify-content-center gap-3 text-muted opacity-50">
                            <i class="bi bi-credit-card-2-front fs-4"></i>
                            <i class="bi bi-paypal fs-4"></i>
                            <i class="bi bi-google fs-4"></i>
                            <i class="bi bi-apple fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <i class="bi bi-cart-x display-1 text-secondary opacity-50"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
            <a href="{{ url('/catalog') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                Start Shopping
            </a>
        </div>
    @endif
</div>

<script type="module">
    document.querySelectorAll('.update-cart').forEach(input => {
        input.addEventListener('change', function() {
            const id = this.closest('tr').dataset.id;
            const quantity = this.value;
            
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update Cart Totals
                    document.querySelectorAll('.cart-total-display').forEach(el => {
                        el.textContent = '$' + data.total.toFixed(2);
                    });
                    document.querySelectorAll('.cart-count-badge').forEach(el => {
                        el.textContent = data.cart_count;
                    });
                } else {
                    alert('Failed to update cart.');
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating cart.');
            });
        });
    });

    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm("Are you sure want to remove?")) {
                const row = this.closest('tr');
                const id = row.dataset.id;

                fetch('{{ route('cart.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                        
                        document.querySelectorAll('.cart-total-display').forEach(el => {
                            el.textContent = '$' + data.total.toFixed(2);
                        });
                        document.querySelectorAll('.cart-count-badge').forEach(el => {
                            el.textContent = data.cart_count;
                        });

                        if (data.cart_count == 0) {
                            window.location.reload();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error removing item.');
                });
            }
        });
    });
</script>

<style>
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-2px);
    }
</style>
@endsection