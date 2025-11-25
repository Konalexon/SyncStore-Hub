@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h1 class="fw-bold mb-4">About SyncStore Hub</h1>
                <p class="lead text-secondary mb-4">We are revolutionizing the way e-commerce works by bridging the gap
                    between automated inventory management and live stream sales.</p>
                <p>Founded in 2024, SyncStore Hub was built with a single mission: to empower sellers with tools that
                    automate the boring stuff so they can focus on what they do best - selling.</p>
                <p>Our platform integrates seamlessly with major wholesalers and Print-on-Demand providers, ensuring your
                    catalog is always up-to-date. With our unique "Live Shop" feature, you can take your products directly
                    to your audience in real-time.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80"
                    class="img-fluid rounded-3 shadow-lg" alt="Our Team">
            </div>
        </div>

        <div class="row g-4 text-center py-5">
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-lightning-charge fs-2"></i>
                    </div>
                    <h4 class="fw-bold">Fast & Reliable</h4>
                    <p class="text-secondary">Our infrastructure is built for speed and stability, ensuring your store is
                        always online.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-shield-check fs-2"></i>
                    </div>
                    <h4 class="fw-bold">Secure</h4>
                    <p class="text-secondary">We take security seriously. Your data and your customers' data are protected
                        by enterprise-grade encryption.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-heart fs-2"></i>
                    </div>
                    <h4 class="fw-bold">Customer First</h4>
                    <p class="text-secondary">Our support team is available 24/7 to help you succeed. Your success is our
                        success.</p>
                </div>
            </div>
        </div>
    </div>
@endsection