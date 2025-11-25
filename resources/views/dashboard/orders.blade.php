@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action border-0">
                                <i class="bi bi-speedometer2 me-2"></i> Overview
                            </a>
                            <a href="{{ url('/dashboard/orders') }}"
                                class="list-group-item list-group-item-action active border-0">
                                <i class="bi bi-bag me-2"></i> My Orders
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="list-group-item list-group-item-action border-0 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h2 class="fw-bold mb-4">My Orders</h2>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4">#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-secondary">You haven't placed any orders
                                            yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection