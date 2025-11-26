@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">My Wishlist</h2>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach($wishlistItems as $item)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $item->product->image }}" class="card-img-top" alt="{{ $item->product->name }}"
                                    style="height: 200px; object-fit: cover;">
                                <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST"
                                    class="position-absolute top-0 end-0 m-2">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm text-danger">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-truncate">{{ $item->product->name }}</h5>
                                <p class="card-text text-muted small mb-3">{{ Str::limit($item->product->description, 60) }}</p>
                                <div class="mt-auto d-grid">
                                    <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-dark rounded-pill w-100">
                                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-heart-break display-1 text-muted mb-3"></i>
                <h3>Your wishlist is empty</h3>
                <p class="text-muted">Save items you love to buy later.</p>
                <a href="{{ url('/catalog') }}" class="btn btn-primary mt-3">Browse Catalog</a>
            </div>
        @endif
    </div>
@endsection