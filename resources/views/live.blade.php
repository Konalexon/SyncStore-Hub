@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Left Column: Video & Products -->
            <div class="col-lg-9">
                <!-- Video Player Area -->
                <div class="live-stream-container bg-black rounded-3 overflow-hidden position-relative mb-4"
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
                                        <span class="font-monospace fw-bold text-warning" id="auctionTimer" style="font-size: 1.1rem;">00:45</span>
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
                                            <span class="h4 fw-bold mb-0 text-white" id="currentBid">${{ number_format($stream->product->price, 2) }}</span>
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-100 fw-bold py-2 rounded-3 position-relative overflow-hidden" onclick="placeBid()">
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
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-secondary text-white">
                            <i class="bi bi-camera-video-off display-1 mb-3"></i>
                            <h3>Stream is Offline</h3>
                            <p>Check back later for our next live event!</p>
                        </div>
                    @endif
                </div>

                <!-- Shop Products (Moved below video) -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold mb-0">Featured Products</h3>
                        <span class="badge bg-danger">Live Deals</span>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 g-4">
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
                                        <button class="btn btn-outline-primary w-100"
                                            onclick="addToCart({{ $product->id }})">
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Live Chat (Moved to Sidebar) -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="min-height: 600px;">
                    <div
                        class="card-header bg-white fw-bold border-bottom-0 pt-3 d-flex justify-content-between align-items-center">
                        <span>Live Chat</span>
                        <span class="badge bg-success bg-opacity-10 text-success small">Online</span>
                    </div>
                    <div class="card-body overflow-auto d-flex flex-column" id="chatBox" style="height: 500px;">
                        <!-- Chat messages will appear here dynamically -->
                        <div class="text-center text-muted mt-auto mb-auto small">
                            <i class="bi bi-chat-dots fs-4 mb-2 d-block"></i>
                            Welcome to the live chat!<br>Say hello to everyone.
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type a message..." id="chatInput">
                            <button class="btn btn-primary" type="button" onclick="sendMessage()">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let lastStatus = null;
        let lastProductId = null;

        document.addEventListener('DOMContentLoaded', function () {
            // BroadcastChannel Receiver (Simulates Stream from Admin)
            const canvas = document.getElementById('streamCanvas');
            const ctx = canvas ? canvas.getContext('2d') : null;
            const placeholder = document.getElementById('videoPlaceholder');
            const broadcastChannel = new BroadcastChannel('live_stream_channel');

            broadcastChannel.onmessage = (event) => {
                if (event.data.type === 'video-frame' && ctx) {
                    const img = new Image();
                    img.onload = () => {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);
                        if (placeholder) placeholder.classList.add('d-none');
                    };
                    img.src = event.data.data;
                }
            };

            // Polling for Stream Status
            setInterval(checkStreamStatus, 3000);

            // Viewer Count Simulation
            let viewers = 0;
            const viewerElement = document.getElementById('viewerCount');
            if (viewerElement) {
                setInterval(() => {
                    const change = Math.floor(Math.random() * 5) - 2;
                    viewers = Math.max(0, viewers + change);
                    if (Math.random() > 0.9) viewers += Math.floor(Math.random() * 10);
                    viewerElement.innerText = viewers;
                }, 2000);
            }

            // Auction Timer
            const timerElement = document.getElementById('auctionTimer');
            if (timerElement) {
                let timeLeft = 45; // 45 seconds
                const timerInterval = setInterval(() => {
                    timeLeft--;
                    if (timeLeft < 0) {
                        clearInterval(timerInterval);
                        timerElement.innerText = "ENDED";
                        timerElement.classList.add('text-danger');
                        endAuctionFrontend();
                    } else {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        timerElement.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                }, 1000);
            }

            // Chat Enter Key
            const chatInput = document.getElementById('chatInput');
            if (chatInput) {
                chatInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        sendMessage();
                    }
                });
            }
        });

        function checkStreamStatus() {
            fetch('{{ url("/live/status") }}')
                .then(response => response.json())
                .then(data => {
                    if (lastStatus !== null && (data.is_active !== lastStatus || data.product_id !== lastProductId)) {
                        console.log("Stream status changed, reloading...");
                        window.location.reload();
                    }
                    lastStatus = data.is_active;
                    lastProductId = data.product_id;
                })
                .catch(err => console.error("Error polling status:", err));
        }

        function endAuctionFrontend() {
            // Logic to remove current product and slide sidebar
            // Since products are now in a grid, we might want to fade out the first card
            const productGrid = document.querySelector('.row-cols-md-3');
            if (productGrid && productGrid.children.length > 0) {
                const firstProduct = productGrid.children[0];
                firstProduct.classList.add('fade-out-left');

                setTimeout(() => {
                    firstProduct.remove();
                }, 500);
            }
        }

        function placeBid() {
            const bidElement = document.getElementById('currentBid');
            let currentPrice = parseFloat(bidElement.innerText.replace('$', '').replace(',', ''));
            currentPrice += 10;
            bidElement.innerText = '$' + currentPrice.toFixed(2);
            addChatMessage('System', `New bid placed! Current price: $${currentPrice.toFixed(2)}`, 'text-warning');
        }

        let lastMessage = "";
        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();

            if (message) {
                if (message === lastMessage) {
                    alert("Please do not repeat the same message.");
                    return;
                }

                addChatMessage('You', message, 'text-primary fw-bold');
                lastMessage = message;
                input.value = '';
            }
        }

        function addChatMessage(user, text, userClass = 'fw-bold') {
            const chatBox = document.getElementById('chatBox');
            if (chatBox.querySelector('.text-center')) {
                chatBox.innerHTML = '';
            }
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `<span class="${userClass}">${user}:</span> <span class="text-secondary">${text}</span>`;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>

    <style>
        .fade-out-left {
            animation: fadeOutLeft 0.5s forwards;
        }

        @keyframes fadeOutLeft {
            to {
                opacity: 0;
                transform: translateX(-100%);
            }
        }
    </style>
@endsection