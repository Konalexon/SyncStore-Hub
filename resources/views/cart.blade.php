@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Shopping Cart</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 50%">Product</th>
                                        <th style="width: 20%">Price</th>
                                        <th style="width: 20%">Quantity</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $details)
                                        <tr data-id="{{ $id }}">
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $details['image'] }}" width="60" height="60"
                                                        class="rounded object-fit-cover">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($details['price'], 2) }}</td>
                                            <td>
                                                <input type="number" value="{{ $details['quantity'] }}"
                                                    class="form-control quantity update-cart" style="width: 80px;">
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger remove-from-cart">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold">${{ number_format($total, 2) }}</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100 py-2 fw-bold">
                                Proceed to Checkout <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Looks like you haven't added anything yet.</p>
                <a href="{{ url('/catalog') }}" class="btn btn-primary mt-3">Start Shopping</a>
            </div>
        @endif
    </div>

    <script type="module">
        $(".update-cart").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection