@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Filters</h5>

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
                    <p class="mb-0 text-secondary">Showing {{ $products->count() }} results</p>
                    <select class="form-select w-auto border-0 shadow-sm">
                        <option selected>Sort by: Featured</option>
                </div>
            </div>
@endsection