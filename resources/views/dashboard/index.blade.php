@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center p-4">
                        <div class="avatar-placeholder bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center display-4 fw-bold"
                            style="width: 80px; height: 80px;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-danger btn-sm"
                                onclick="document.getElementById('logout-form').submit()">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Profile Settings -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i>Profile Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Address Book -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2"></i>Shipping Address</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.address') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Street Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $user->address }}"
                                        placeholder="123 Main St">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ $user->city }}"
                                        placeholder="New York">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" name="zip" class="form-control" value="{{ $user->zip }}"
                                        placeholder="10001">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Update Address</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order History -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-bag-check me-2"></i>Order History</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-outline-primary">View</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-bag-x display-4 opacity-25 mb-3 d-block"></i>
                                                No orders found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection