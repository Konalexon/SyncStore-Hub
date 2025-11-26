@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold display-4">Live Streams</h1>
            <p class="lead text-muted">Join a live shopping event happening now!</p>
        </div>

        @if($activeStreams->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($activeStreams as $stream)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm hover-scale transition-all">
                            <div class="position-relative">
                                <!-- Thumbnail Placeholder (could be a snapshot in future) -->
                                <div class="bg-dark rounded-top d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="bi bi-play-circle-fill text-white display-1 opacity-50"></i>
                                </div>

                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger animate-pulse">
                                        <i class="bi bi-circle-fill small me-1"></i> LIVE
                                    </span>
                                </div>

                                <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-to-t from-black">
                                    <h5 class="text-white mb-0 text-truncate">{{ $stream->title }}</h5>
                                    <small class="text-white-50">Host: {{ $stream->user->name ?? 'Unknown Host' }}</small>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-tag-fill me-1 text-primary"></i>
                                        {{ $stream->product ? $stream->product->name : 'No Product' }}
                                    </span>
                                </div>

                                <a href="{{ route('live.show', $stream->id) }}" class="btn btn-primary w-100 fw-bold">
                                    Watch Stream <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-camera-video-off display-1 text-muted opacity-25"></i>
                </div>
                <h3>No Active Streams</h3>
                <p class="text-muted">Check back later or start your own stream if you are a host!</p>
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'host')
                        <a href="{{ route('admin.live') }}" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-broadcast me-2"></i> Start Streaming
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <style>
        .hover-scale:hover {
            transform: translateY(-5px);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .bg-gradient-to-t {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        }
    </style>
@endsection