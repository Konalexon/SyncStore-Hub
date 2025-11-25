@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/catalog') }}">Catalog</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->category }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-5 text-center bg-light rounded">
                        <img src="https://placehold.co/600x600?text={{ urlencode($product->name) }}" class="img-fluid"
                            id="mainImage" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-3">
                        <img src="https://placehold.co/150x150?text=1" class="img-thumbnail cursor-pointer"
                            onclick="changeImage(this.src)">
                    </div>
                    <div class="col-3">
                        <img src="https://placehold.co/150x150?text=2" class="img-thumbnail cursor-pointer"
                            onclick="changeImage(this.src)">
                    </div>
                    <div class="col-3">
                        <img src="https://placehold.co/150x150?text=3" class="img-thumbnail cursor-pointer"
                            onclick="changeImage(this.src)">
                    </div>
                    <div class="col-3">
                        <img src="https://placehold.co/150x150?text=4" class="img-thumbnail cursor-pointer"
                            onclick="changeImage(this.src)">
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="mb-3">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">In Stock</span>
                    <span
                        class="badge bg-light text-secondary border px-3 py-2 rounded-pill ms-2">{{ $product->category }}</span>
                </div>
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-secondary small">(4.5/5 based on 12 reviews)</span>
                </div>

                <h2 class="display-5 fw-bold text-primary mb-4">${{ number_format($product->price, 2) }}</h2>

                <div class="mb-4">
                    <h6 class="fw-bold">Description</h6>
                    <p class="text-secondary">{{ $product->description }}</p>
                </div>

                <div class="card bg-light border-0 p-3 mb-4">
                    <div class="d-flex gap-3 align-items-center">
                        <i class="bi bi-shield-check fs-3 text-primary"></i>
                        <div>
                            <h6 class="fw-bold mb-0">Premium Experience</h6>
                            <small class="text-secondary">2-year warranty and 24/7 support included.</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-5">
                    <div class="input-group w-auto">
                        <button class="btn btn-outline-secondary" type="button" onclick="decrementQty()">-</button>
                        <input type="text" class="form-control text-center" value="1" style="width: 60px;" id="qtyInput">
                        <button class="btn btn-outline-secondary" type="button" onclick="incrementQty()">+</button>
                    </div>
                    <button class="btn btn-primary btn-lg flex-grow-1 rounded-pill" onclick="addToCart({{ $product->id }})">
                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                    </button>
                    <button class="btn btn-outline-dark btn-lg rounded-circle">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <hr>

                <div class="d-flex gap-4 text-secondary small">
                    <span><i class="bi bi-truck me-1"></i> Free Shipping</span>
                    <span><i class="bi bi-arrow-repeat me-1"></i> 30-Day Returns</span>
                    <span><i class="bi bi-shield-lock me-1"></i> Secure Payment</span>
                </div>
            </div>
        </div>

        <!-- Reviews & Specs Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs"
                            type="button">Technical Specifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button">Reviews (12)</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="specs" role="tabpanel">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-25">Brand</th>
                                    <td>SyncStore</td>
                                </tr>
                                <tr>
                                    <th scope="row">Model</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Warranty</th>
                                    <td>2 Years</td>
                                </tr>
                                <tr>
                                    <th scope="row">In the Box</th>
                                    <td>Product, Manual, Charger</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h6 class="fw-bold">John Doe</h6>
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                        <p class="text-secondary mb-0">Great product! Exactly what I needed properly synced
                                            with my inventory.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        function incrementQty() {
            const input = document.getElementById('qtyInput');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQty() {
            const input = document.getElementById('qtyInput');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection