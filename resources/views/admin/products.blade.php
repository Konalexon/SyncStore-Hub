@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage Products</h2>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <!-- Add Product Form -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Add New Product</div>
                    <div class="card-body">
                        <form action="{{ url('/admin/products') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Audio">Audio</option>
                                    <option value="Wearables">Wearables</option>
                                    <option value="Computers">Computers</option>
                                    <option value="Cameras">Cameras</option>
                                    <option value="Gaming">Gaming</option>
                                    <option value="Accessories">Accessories</option>
                                    <option value="Fashion">Fashion</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image URL</label>
                                <input type="url" name="image" class="form-control" placeholder="https://..." required>
                            </div>

                            <div class="alert alert-info small">
                                <i class="bi bi-magic me-1"></i> Description will be auto-generated based on product
                                details.
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-lg me-1"></i> Add Product with Magic
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $product->image }}" class="rounded" width="40" height="40"
                                                    style="object-fit: cover;">
                                                <span class="fw-bold">{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-secondary border">{{ $product->category }}</span>
                                        </td>
                                        <td class="fw-bold text-primary">${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection