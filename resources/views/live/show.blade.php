@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Row 1: Stream + Chat -->
        <div class="row g-4 mb-4">
            <!-- Left Column: Video -->
            <div class="col-lg-9">
                <!-- Video Player Area -->
                <div class="live-stream-container bg-black rounded-3 overflow-hidden position-relative"
                    style="aspect-ratio: 16/9;">
                    @if(isset($stream) && $stream && $stream->is_active)
                        <!-- Live Badge -->
                        <div class="position-absolute top-0 start-0 m-3 z-3">
                            <span class="badge bg-danger animate-pulse">
                                <i class="bi bi-circle-fill small me-1"></i> LIVE
                            </span>
                            <span class="badge bg-dark bg-opacity-50 ms-2">
                                <i class="bi bi-eye me-1"></i> <span id="viewerCount">0</span> watching
                            </span>
                        </div>

                        <!-- Simulated Live Stream Feed (User View - Receiving from Admin) -->
                        <div class="w-100 h-100 bg-black position-relative">
                            <!-- Canvas for rendering the stream -->
                            <canvas id="streamCanvas" class="w-100 h-100 object-fit-cover"></canvas>

                            <!-- Fallback/Loading State -->
                            <div id="videoPlaceholder"
                                class="position-absolute top-50 start-50 translate-middle text-center text-white">
                                <div class="spinner-grow text-danger mb-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h4 class="fw-bold">Waiting for Stream...</h4>
                                <p class="small text-white-50">Open Admin Panel in another tab to start broadcasting.</p>
                            </div>

                            <!-- Product Overlay (Always Visible if Stream is Active) -->
                            <div class="position-absolute top-50 start-0 translate-middle-y m-4 p-3 rounded-4 text-white shadow-lg"
                                style="width: 280px; background: rgba(20, 20, 20, 0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1);">

                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-danger animate-pulse">LIVE AUCTION</span>
                                    <div class="text-end">
                                        <small class="text-white-50 d-block" style="font-size: 0.7rem;">ENDS IN</small>
                                        <span class="font-monospace fw-bold text-warning" id="auctionTimer"
                                            style="font-size: 1.1rem;">00:45</span>
                                    </div>
                                </div>

                                @if($stream->product)
                                    <img src="{{ $stream->product->image }}" class="rounded-3 w-100 mb-3"
                                        style="height: 160px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">

                                    <h5 class="fw-bold mb-1 text-truncate">{{ $stream->product->name }}</h5>
                                    <p class="text-white-50 small mb-3 text-truncate">{{ $stream->product->description }}</p>

                                    <div class="d-flex justify-content-between align-items-end mb-3">
                                        <div>
                                            <small class="text-white-50 d-block" style="font-size: 0.75rem;">CURRENT BID</small>
                                            <span class="h4 fw-bold mb-0 text-white"
                                                id="currentBid">${{ number_format($stream->product->price, 2) }}</span>
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-100 fw-bold py-2 rounded-3 position-relative overflow-hidden"
                                        onclick="placeBid()">
                                        <span class="position-relative z-1">BID +$10</span>
                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-25"
                                            style="transform: skewX(-20deg) translateX(-150%); transition: transform 0.5s;"
                                            onmouseover="this.style.transform='skewX(-20deg) translateX(150%)'"
                                            onmouseout="this.style.transform='skewX(-20deg) translateX(-150%)'"></div>
                                    </button>
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-hourglass-split fs-1 text-white-50 mb-3"></i>
                                        <h5 class="fw-bold">Waiting for next item...</h5>
                                        <p class="text-white-50 small">The host is selecting the next product.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Offline State -->
                        <div
                            class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-secondary text-white">
                            <i class="bi bi-camera-video-off display-1 mb-3"></i>
                            <h3>Stream is Offline</h3>
                            <p>Check back later for our next live event!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Chat -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Live Chat</h5>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <div id="chatMessages" class="flex-grow-1 overflow-auto mb-3" style="scrollbar-width: thin;">
                            <div class="text-center text-muted small my-2">
                                Welcome to the chat! Be nice.
                            </div>
                        </div>

                        @auth
                            <div class="input-group">
                                <input type="text" id="chatInput" class="form-control border-0 bg-light"
                                    placeholder="Type a message..." onkeypress="if(event.key === 'Enter') sendMessage()">
                                <button class="btn btn-primary" onclick="sendMessage()">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        @else
                            <div class="text-center p-2 bg-light rounded">
                                <p class="small text-muted mb-2">Please login to chat</p>
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary w-100">Sign In</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Products -->
        <div class="row g-4">
            <div class="col-12">
                <!-- Shop Products -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold mb-0">Featured Products</h3>
                        <span class="badge bg-danger">Live Deals</span>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"
                                            style="height: 200px; object-fit: cover;">
                                        <span
                                            class="position-absolute top-0 end-0 badge bg-primary m-2">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold text-truncate">{{ $product->name }}</h5>
                                        <p class="card-text text-muted small text-truncate">{{ $product->description }}</p>
                                        <button class="btn btn-outline-primary w-100" onclick="addToCart({{ $product->id }})">
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import { StreamReceiver } from '/js/stream-simulation.js';

        const data = response.data;

        // Update Viewer Count
        if (viewerCount) {
            viewerCount.innerText = Math.floor(Math.random() * 50) + 10;
        }

        // Update Auction Info
        if (data.product) {
            const currentBidEl = document.getElementById('currentBid');
            if (currentBidEl) {
                currentBidEl.innerText = '$' + parseFloat(data.product.price).toFixed(2);
            }

            // Sync Timer
            if (data.auction_end_time && auctionTimer) {
                const endTime = new Date(data.auction_end_time).getTime();
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance > 0) {
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    auctionTimer.innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                } else {
                    auctionTimer.innerText = "ENDED";
                }
            }
            if (!message) return;

            try {
                // Ensure CSRF token is sent
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await axios.post('/chat/send', { message }, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                if (response.data.success) {
                    const chatBox = document.getElementById('chatMessages');
                    const msgDiv = document.createElement('div');
                    msgDiv.className = 'mb-2';
                    msgDiv.innerHTML = `<span class="fw-bold text-primary">${response.data.user}:</span> ${response.data.message}`;
                    chatBox.appendChild(msgDiv);

                    if (response.data.bot_reply) {
                        const botDiv = document.createElement('div');
                        botDiv.className = 'mb-2';
                        botDiv.innerHTML = `<span class="fw-bold text-success">AI Assistant:</span> ${response.data.bot_reply.message}`;
                        chatBox.appendChild(botDiv);
                    }

                    input.value = '';
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            } catch (error) {
                console.error('Chat error:', error);
                if (error.response && error.response.status === 403) {
                    alert('You are banned from chat.');
                } else {
                    alert('Error sending message');
                }
            }
        };
    </script>
@endsection