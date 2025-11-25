@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">
                        <i class="bi bi-lightning-fill"></i> Automatic Product Updates
                    </span>
                    <h1>Automatic Product Updates With <span>Smart Markup</span></h1>
                    <p>Say goodbye to manual catalog updates. Our platform automatically syncs products from your
                        wholesalers and POD providers, calculates margins, and keeps everything ready for livestream sales.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ url('/catalog') }}" class="btn btn-primary btn-lg rounded-pill">Browse Catalog</a>
                        <a href="{{ url('/live') }}" class="btn btn-outline-dark btn-lg rounded-pill">
                            <i class="bi bi-play-circle-fill text-danger"></i> Watch Live Demo
                        </a>
                    </div>
                    <div class="mt-5 d-flex gap-4 text-secondary">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i> No credit card required
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i> 14-day free trial
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="hero-image position-relative">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2426&q=80"
                            alt="Dashboard Preview">
                        <!-- Floating Card -->
                        <div class="position-absolute bottom-0 start-0 bg-white p-3 rounded-3 shadow-lg m-4 d-none d-md-block"
                            style="max-width: 250px;">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-success rounded-circle p-2 text-white">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Sales Growth</h6>
                                    <small class="text-success">+24% this week</small>
                                </div>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold display-5">10K+</h2>
                    <p class="mb-0 opacity-75">Active Products</p>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold display-5">500+</h2>
                    <p class="mb-0 opacity-75">Happy Sellers</p>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h2 class="fw-bold display-5">99.9%</h2>
                    <p class="mb-0 opacity-75">Uptime</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold display-5">24/7</h2>
                    <p class="mb-0 opacity-75">Auto Sync</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">How It Works</h2>
                <p class="text-secondary">Three simple steps to transform your product management and boost your livestream
                    sales.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-wrapper mx-auto">
                            <span class="fw-bold">1</span>
                        </div>
                        <h3>Connect Suppliers</h3>
                        <p>Integrate your wholesalers and POD providers with one click. Our platform supports all major
                            suppliers and automatically syncs their product catalogs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-wrapper mx-auto bg-warning text-dark">
                            <span class="fw-bold">2</span>
                        </div>
                        <h3>Set Your Margins</h3>
                        <p>Define your markup rules once. The system automatically calculates your selling price and profit
                            margins for every product, keeping them updated 24/7.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="icon-wrapper mx-auto bg-success text-white">
                            <span class="fw-bold">3</span>
                        </div>
                        <h3>Start Selling Live</h3>
                        <p>Launch your livestream store with confidence. Access your entire catalog instantly, add items to
                            the live overlay, and process orders while you stream.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems We Solve -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Problems We Solve</h2>
                <p class="text-secondary">Stop wasting time on manual tasks and focus on what matters - selling.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="d-flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 text-danger rounded p-3">
                                    <i class="bi bi-x-lg fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">No More Manual Updates</h5>
                                <p class="text-secondary mb-0">Forget about spending hours updating product information,
                                    prices, and availability. Our automation handles everything in real-time.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="d-flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 text-success rounded p-3">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">Automatic Margin Calculation</h5>
                                <p class="text-secondary mb-0">Let your markup rules work for you. The system calculates
                                    optimal pricing automatically, safeguarding your profit margins at a glance.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="d-flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 text-info rounded p-3">
                                    <i class="bi bi-camera-video fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">Livestream Sales Ready</h5>
                                <p class="text-secondary mb-0">Stream seamlessly with your livestream platform. Display
                                    products, prices, and inventory in real-time during your sales events.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <div class="d-flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                                    <i class="bi bi-arrow-repeat fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">Real-Time Synchronization</h5>
                                <p class="text-secondary mb-0">Tension availability, pricing changes, and new items are
                                    automatically synced across all your channels without any manual intervention.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container py-5">
            <h2 class="fw-bold mb-4">Ready to Transform Your Sales?</h2>
            <p class="lead mb-5 opacity-75">Join hundreds of successful sellers who automated their product
                management<br>and boosted their livestream sales. Start your free trial today.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="btn btn-light btn-lg rounded-pill px-5 text-primary fw-bold">Start Free Trial</a>
                <a href="#" class="btn btn-outline-light btn-lg rounded-pill px-5">Schedule Demo</a>
            </div>
            <p class="mt-4 small opacity-50">No credit card required • 14-day free trial • Cancel anytime</p>
        </div>
    </section>
@endsection