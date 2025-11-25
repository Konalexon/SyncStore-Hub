<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SyncStore Hub') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles & Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-box-seam-fill"></i> SyncStore Hub
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('catalog') ? 'active' : '' }}"
                                href="{{ url('/catalog') }}">Catalog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('live') ? 'active' : '' }}"
                                href="{{ url('/live') }}">Live Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                                href="{{ url('/about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                                href="{{ url('/contact') }}">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        @auth
                            <a href="{{ url('/cart') }}" class="text-dark position-relative me-2">
                                <i class="bi bi-cart3 fs-4"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.6rem;">
                                    0
                                </span>
                            </a>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Sign In</a>
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Sign Up</a>
                        @else
                            <div class="dropdown">
                                <a class="btn btn-light dropdown-toggle rounded-pill px-3" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}">Admin Panel</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/dashboard/orders') }}">My Orders</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5>SyncStore Hub</h5>
                        <p class="text-white-50">Automated product catalog and sales platform for seamless online and
                            live event commerce.</p>
                        <div class="social-links mt-4">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter-x"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <h5>Platform</h5>
                        <ul>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Integrations</a></li>
                            <li><a href="#">Live Events</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 mb-4">
                        <h5>Company</h5>
                        <ul>
                            <li><a href="{{ url('/about') }}">About Us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5>Newsletter</h5>
                        <p class="text-white-50 mb-3">Subscribe to get the latest updates and news.</p>
                        <form class="d-flex gap-2">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button class="btn btn-primary">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="copyright">
                    &copy; {{ date('Y') }} SyncStore Hub. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>