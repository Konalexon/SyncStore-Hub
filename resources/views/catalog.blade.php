@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4"><i class="bi bi-funnel-fill me-2"></i>Filters</h5>

                        <form action="{{ url('/catalog') }}" method="GET">
                            <!-- Categories -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Categories</h6>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="cat_all"
                                            value="All" {{ request('category') == 'All' || !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label" for="cat_all">All Products</label>
                                    </div>
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category"
                                                id="cat_{{ $category }}" value="{{ $category }}" {{ request('category') == $category ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            <label class="form-check-label" for="cat_{{ $category }}">{{ $category }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Price Range</h6>
                                <label for="priceRange" class="form-label d-flex justify-content-between">
                                    <span>$0</span>
                                    <span>${{ request('price_range', 2000) }}</span>
                                </label>
                                <input type="range" class="form-range" min="0" max="2000" step="10" id="priceRange"
                                    name="price_range" value="{{ request('price_range', 2000) }}"
                                    onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 text-secondary">Showing {{ $products->total() }} results</p>
                    <select class="form-select w-auto border-0 shadow-sm">
                        <option selected>Sort by: Featured</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"
                                        style="height: 200px; object-fit: cover;">
                                    <span class="position-absolute top-0 end-0 badge bg-primary m-2">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST"
                                        class="position-absolute top-0 start-0 m-2">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-light rounded-circle shadow-sm {{ Auth::check() && Auth::user()->wishlist->contains('product_id', $product->id) ? 'text-danger' : 'text-muted' }}">
                                            <i class="bi bi-heart-fill"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small mb-3">{{ Str::limit($product->description, 60) }}</p>
                                    <div class="mt-auto d-grid">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-dark rounded-pill w-100">
                                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
                            <h3>No products found</h3>
                            <p class="text-muted">Try adjusting your filters or check back later.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection