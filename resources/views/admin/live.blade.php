@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Left Column: Stream & Webcam -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-camera-video me-2"></i>Live Stream Preview</h5>
                    <span class="badge bg-danger animate-pulse d-none" id="liveIndicator">LIVE</span>
                </div>
                <div class="card-body p-0 bg-black position-relative" style="height: 500px;">
                    <!-- Webcam Video -->
                    <video id="webcamVideo" autoplay playsinline muted
                        class="w-100 h-100 object-fit-cover d-none"></video>

                    <!-- Placeholder -->
                    <div id="webcamPlaceholder"
                        class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white-50">
                        <i class="bi bi-camera-video-off display-1 mb-3"></i>
                        <h4>Stream is Offline</h4>
                        <p>Click "Go Live" to start streaming.</p>
                    </div>
                </div>
                <div class="card-footer bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button id="startStreamBtn" class="btn btn-success rounded-pill px-4 fw-bold">
                                <i class="bi bi-broadcast me-2"></i>Go Live
                            </button>
                            <button id="stopStreamBtn" class="btn btn-danger rounded-pill px-4 fw-bold d-none">
                                <i class="bi bi-stop-circle me-2"></i>Stop Stream
                            </button>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-eye me-1"></i> <span id="viewerCount">0</span> Viewers
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auction Controls -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white p-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-hammer me-2"></i>Auction Controls</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Select Product to Auction</label>
                            <select class="form-select form-select-lg" id="productSelect">
                                <option selected disabled>Choose a product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-image="{{ $product->image }}"
                                        data-price="{{ $product->price }}">
                                        {{ $product->name }} (${{ $product->price }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Auction Duration</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(30)">30s</button>
                                <button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(60)">1m</button>
                                <button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(120)">2m</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-3 d-none" id="activeAuctionPanel">
                        <div class="d-flex align-items-center gap-3">
                            <img id="auctionImage" src="" class="rounded" width="60" height="60">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold" id="auctionTitle">Product Name</h6>
                                <div class="text-primary fw-bold" id="auctionPrice">$0.00</div>
                            </div>
                            <div class="text-end">
                                <div class="display-6 fw-bold text-danger" id="auctionTimer">00:00</div>
                                <button class="btn btn-sm btn-danger" onclick="stopAuction()">End Auction</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Chat & Moderation -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white p-3 border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2"></i>Live Chat</h5>
                    <span class="badge bg-light text-dark border">Moderation Mode</span>
                </div>
                <div class="card-body p-0 d-flex flex-column" style="height: 600px;">
                    <div id="chatBox" class="flex-grow-1 p-3 overflow-auto bg-light">
                        <!-- Chat messages will appear here -->
                        <div class="text-center text-muted mt-5">
                            <i class="bi bi-chat-square-text fs-1 opacity-25"></i>
                            <p class="mt-2 small">Chat is empty</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white border-top">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type a message as Admin..."
                                id="adminChatInput">
                            <button class="btn btn-primary" onclick="sendAdminMessage()">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        @extends('layouts.app')

        @section('content')
                    <div class="container-fluid py-4"><div class="row g-4">< !-- Left Column: Stream & Webcam --><div class="col-lg-8"><div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4"><div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center"><h5 class="mb-0"><i class="bi bi-camera-video me-2"></i>Live Stream Preview</h5><span class="badge bg-danger animate-pulse d-none" id="liveIndicator">LIVE</span></div><div class="card-body p-0 bg-black position-relative" style="height: 500px;">< !-- Webcam Video --><video id="webcamVideo" autoplay playsinline muted class="w-100 h-100 object-fit-cover d-none"></video>< !-- Placeholder --><div id="webcamPlaceholder"
                    class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white-50"><i class="bi bi-camera-video-off display-1 mb-3"></i><h4>Stream is Offline</h4><p>Click "Go Live" to start streaming.</p></div></div><div class="card-footer bg-white p-3"><div class="d-flex justify-content-between align-items-center"><div class="d-flex gap-2"><button id="startStreamBtn" class="btn btn-success rounded-pill px-4 fw-bold"><i class="bi bi-broadcast me-2"></i>Go Live </button><button id="stopStreamBtn" class="btn btn-danger rounded-pill px-4 fw-bold d-none"><i class="bi bi-stop-circle me-2"></i>Stop Stream </button></div><div class="text-muted small"><i class="bi bi-eye me-1"></i><span id="viewerCount">0</span>Viewers </div></div></div></div>< !-- Auction Controls --><div class="card border-0 shadow-sm rounded-4"><div class="card-header bg-white p-3 border-bottom-0"><h5 class="mb-0 fw-bold"><i class="bi bi-hammer me-2"></i>Auction Controls</h5></div><div class="card-body p-4"><div class="row g-4"><div class="col-md-6"><label class="form-label fw-bold">Select Product to Auction</label><select class="form-select form-select-lg" id="productSelect"><option selected disabled>Choose a product...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-image="{{ $product->image }}"
                        data-price="{{ $product->price }}">
                        {{ $product->name }}
                    (${{ $product->price }}) </option>@endforeach </select></div><div class="col-md-6"><label class="form-label fw-bold">Auction Duration</label><div class="d-flex gap-2"><button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(30)">30s</button><button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(60)">1m</button><button class="btn btn-outline-primary flex-grow-1" onclick="setTimer(120)">2m</button></div></div></div><div class="mt-4 p-3 bg-light rounded-3 d-none" id="activeAuctionPanel"><div class="d-flex align-items-center gap-3"><img id="auctionImage" src="" class="rounded" width="60" height="60"><div class="flex-grow-1"><h6 class="mb-0 fw-bold" id="auctionTitle">Product Name</h6><div class="text-primary fw-bold" id="auctionPrice">$0.00</div></div><div class="text-end"><div class="display-6 fw-bold text-danger" id="auctionTimer">00:00</div><button class="btn btn-sm btn-danger" onclick="stopAuction()">End Auction</button></div></div></div></div></div></div>< !-- Right Column: Chat & Moderation --><div class="col-lg-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-header bg-white p-3 border-bottom-0 d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold"><i class="bi bi-chat-dots me-2"></i>Live Chat</h5><span class="badge bg-light text-dark border">Moderation Mode</span></div><div class="card-body p-0 d-flex flex-column" style="height: 600px;"><div id="chatBox" class="flex-grow-1 p-3 overflow-auto bg-light">< !-- Chat messages will appear here --><div class="text-center text-muted mt-5"><i class="bi bi-chat-square-text fs-1 opacity-25"></i><p class="mt-2 small">Chat is empty</p></div></div><div class="p-3 bg-white border-top"><div class="input-group"><input type="text" class="form-control" placeholder="Type a message as Admin..."

                    id="adminChatInput"><button class="btn btn-primary" onclick="sendAdminMessage()"><i class="bi bi-send"></i></button></div></div></div></div></div></div></div><style>.animate-pulse {
                        animation: pulse 1.5s infinite;
                    }

                    @keyframes pulse {
                        0% {
                            opacity: 1;
                        }

                        50% {
                            opacity: 0.5;
                        }

                        100% {
                            opacity: 1;
                        }
                    }
            </style>

            <script type="module">
                import { StreamBroadcaster } from '/resources/js/stream-simulation.js';

                // Webcam Logic
                const video = document.getElementById('webcamVideo');
                const placeholder = document.getElementById('webcamPlaceholder');
                const startBtn = document.getElementById('startStreamBtn');
                const stopBtn = document.getElementById('stopStreamBtn');
                const liveIndicator = document.getElementById('liveIndicator');

                startBtn.addEventListener('click', async () => {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                        video.srcObject = stream;
                        video.classList.remove('d-none');
                        placeholder.classList.add('d-none');
                        startBtn.classList.add('d-none');
                        stopBtn.classList.remove('d-none');
                        liveIndicator.classList.remove('d-none');

                        // Start Broadcasting Frames
                        StreamBroadcaster.start(video);

                        // Notify server
                        axios.post('/admin/live/start');
                    } catch (err) {
                        alert('Error accessing webcam: ' + err.message);
                    }
                });

                stopBtn.addEventListener('click', () => {
                    const stream = video.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;

                    video.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                    startBtn.classList.remove('d-none');
                    stopBtn.classList.add('d-none');
                    liveIndicator.classList.add('d-none');

                    // Stop Broadcasting
                    StreamBroadcaster.stop();

                    // Notify server
                    axios.post('/admin/live/stop');
                });

                // Auction Logic
                window.setTimer = function (seconds) {
                    const productSelect = document.getElementById('productSelect');
                    const selectedOption = productSelect.options[productSelect.selectedIndex];

                    if (selectedOption.disabled) {
                        alert('Please select a product first.');
                        return;
                    }

                    const product = {
                        id: productSelect.value,
                        name: selectedOption.text.split(' ($')[0],
                        price: selectedOption.getAttribute('data-price'),
                        image: selectedOption.getAttribute('data-image')
                    };

                    // Show active panel
                    document.getElementById('activeAuctionPanel').classList.remove('d-none');
                    document.getElementById('auctionImage').src = product.image;
                    document.getElementById('auctionTitle').innerText = product.name;
                    document.getElementById('auctionPrice').innerText = '$' + product.price;

                    // Start Timer
                    let timeLeft = seconds;
                    const timerDisplay = document.getElementById('auctionTimer');

                    const interval = setInterval(() => {
                        const minutes = Math.floor(timeLeft / 60);
                        const secs = timeLeft % 60;
                        timerDisplay.innerText = `${minutes}:${secs < 10 ? '0' : ''}${secs}`;

                        if (timeLeft <= 0) {
                            clearInterval(interval);
                            timerDisplay.innerText = "ENDED";
                        }
                        timeLeft--;
                    }, 1000);

                    // Notify server
                    axios.post('/admin/live/auction/start', {
                        product_id: product.id,
                        duration: seconds
                    });
                };
            </script>
        @endsection