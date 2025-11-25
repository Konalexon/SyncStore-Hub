@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Live Stream Control Center</h2>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="row g-4">
            <!-- Main Control Panel -->
            <div class="col-lg-8">
                <!-- Stream Status & Preview -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Stream Status</h5>
                            @if($stream && $stream->is_active)
                                <span class="badge bg-success px-3 py-2">ONLINE</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">OFFLINE</span>
                            @endif
                        </div>

                        <div class="bg-black rounded ratio ratio-16x9 mb-3 overflow-hidden position-relative">
                            <video id="adminWebcam" class="w-100 h-100 object-fit-cover" autoplay playsinline muted></video>
                            <div class="position-absolute top-50 start-50 translate-middle text-center text-white" <div
                                class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                <span>Auction Controls</span>
                                <span class="badge bg-warning text-dark font-monospace fs-6" id="adminTimer">00:45</span>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-primary w-100" onclick="updateTimer(30)">
                                            <i class="bi bi-stopwatch me-1"></i> Extend +30s
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-warning w-100" onclick="resetTimer()">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Reset Timer
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-danger w-100" onclick="endAuction()">
                                            <i class="bi bi-hammer me-1"></i> End Auction
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Moderation -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                                <span>Live Chat</span>
                                <span class="badge bg-primary">Mod View</span>
                            </div>
                            <div class="card-body overflow-auto" style="height: 400px;" id="adminChatBox">
                                <div class="text-center text-muted mt-5">
                                    <i class="bi bi-chat-square-text fs-1 mb-2"></i>
                                    <p>Waiting for messages...</p>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Post as Admin..."
                                        id="adminChatInput">
                                    <button class="btn btn-primary" type="button" onclick="sendAdminMessage()">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let auctionTimeLeft = 45;
                let timerInterval;

                document.addEventListener('DOMContentLoaded', function () {
                    const video = document.getElementById('adminWebcam');
                    const placeholder = document.getElementById('webcamPlaceholder');
                    const broadcastChannel = new BroadcastChannel('live_stream_channel');
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Start Admin Timer
                    startAdminTimer();

                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({ video: { width: 1280, height: 720 } }) // Request HD
                            .then(function (stream) {
                                video.srcObject = stream;
                                video.play();
                                placeholder.classList.add('d-none');

                                // Web Worker to handle timing (prevents background tab throttling)
                                const blob = new Blob([`
                                                    self.onmessage = function(e) {
                                                        setInterval(() => {
                                                            self.postMessage('tick');
                                                        }, 1000 / 120); // 120 FPS
                                                    };
                                                `], { type: 'application/javascript' });
                                const worker = new Worker(URL.createObjectURL(blob));

                                worker.onmessage = function (e) {
                                    if (!video.paused && !video.ended) {
                                        // Higher resolution (720p) and better quality
                                        canvas.width = 1280;
                                        canvas.height = 720;
                                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                        const frame = canvas.toDataURL('image/jpeg', 0.9); // 90% quality
                                        broadcastChannel.postMessage({ type: 'video-frame', data: frame });
                                    }
                                };
                                worker.postMessage('start');

                            })
                            .catch(function (error) {
                                console.error("Error accessing webcam:", error);
                                placeholder.innerHTML = '<i class="bi bi-exclamation-triangle fs-1 text-warning mb-2"></i><p>Camera Access Denied</p>';
                            });
                    } else {
                        placeholder.innerHTML = '<p>Webcam not supported</p>';
                    }
                });

                function startAdminTimer() {
                    const timerDisplay = document.getElementById('adminTimer');
                    clearInterval(timerInterval);
                    timerInterval = setInterval(() => {
                        auctionTimeLeft--;
                        if (auctionTimeLeft < 0) {
                            clearInterval(timerInterval);
                            timerDisplay.innerText = "ENDED";
                            timerDisplay.classList.replace('bg-warning', 'bg-danger');
                            timerDisplay.classList.add('text-white');
                        } else {
                            const minutes = Math.floor(auctionTimeLeft / 60);
                            const seconds = auctionTimeLeft % 60;
                            timerDisplay.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        }
                    }, 1000);
                }

                function sendAdminMessage() {
                    const input = document.getElementById('adminChatInput');
                    const box = document.getElementById('adminChatBox');
                    if (input.value.trim()) {
                        const div = document.createElement('div');
                        div.className = 'mb-2 p-2 bg-light rounded border-start border-4 border-primary';
                        div.innerHTML = `<strong>Admin:</strong> ${input.value} <span class="float-end text-muted small">Just now</span>`;

                        if (box.querySelector('.text-center')) box.innerHTML = '';
                        box.appendChild(div);
                        box.scrollTop = box.scrollHeight;
                        input.value = '';
                    }
                }

                function updateTimer(seconds) {
                    auctionTimeLeft += seconds;
                    // alert(`Timer extended by ${seconds} seconds`); // Removed alert for smoother UX
                    const timerDisplay = document.getElementById('adminTimer');
                    timerDisplay.classList.replace('bg-danger', 'bg-warning'); // Reset color if ended
                    if (timerDisplay.innerText === "ENDED") startAdminTimer();
                }

                function resetTimer() {
                    auctionTimeLeft = 45;
                    const timerDisplay = document.getElementById('adminTimer');
                    timerDisplay.classList.replace('bg-danger', 'bg-warning');
                    startAdminTimer();
                }

                function endAuction() {
                    auctionTimeLeft = 0;
                    // The interval will catch this on next tick
                }
            </script>
@endsection