/**
 * Stream Simulation using BroadcastChannel API
 * This simulates a live stream by sending video frames (Data URLs) from Admin to Viewers.
 * Note: This is for local simulation only. Production would use WebRTC/HLS.
 */

export const StreamBroadcaster = {
    channel: null,
    interval: null,

    start(videoElement, streamId) {
        if (!videoElement || !streamId) return;

        this.channel = new BroadcastChannel(`syncstore_live_stream_${streamId}`);

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        this.interval = setInterval(() => {
            if (videoElement.paused || videoElement.ended) return;

            canvas.width = videoElement.videoWidth / 4; // Downscale for performance
            canvas.height = videoElement.videoHeight / 4;

            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            // Compress to JPEG to reduce message size
            const frame = canvas.toDataURL('image/jpeg', 0.4);

            try {
                this.channel.postMessage({ type: 'frame', data: frame });
            } catch (e) {
                // Ignore channel full errors
            }
        }, 100); // 10 FPS
    },

    stop() {
        if (this.interval) clearInterval(this.interval);
        if (this.channel) {
            this.channel.postMessage({ type: 'status', status: 'offline' });
            this.channel.close();
            this.channel = null;
        }
    }
};

export const StreamReceiver = {
    channel: null,

    init(canvasElement, loadingElement, streamId) {
        if (!canvasElement || !streamId) return;

        this.channel = new BroadcastChannel(`syncstore_live_stream_${streamId}`);
        const ctx = canvasElement.getContext('2d');

        this.channel.onmessage = (event) => {
            const { type, data, status } = event.data;

            if (type === 'frame') {
                if (loadingElement) loadingElement.classList.add('d-none');

                const img = new Image();
                img.onload = () => {
                    canvasElement.width = img.width;
                    canvasElement.height = img.height;
                    ctx.drawImage(img, 0, 0);
                };
                img.src = data;
            } else if (type === 'status' && status === 'offline') {
                if (loadingElement) loadingElement.classList.remove('d-none');
                // Clear canvas
                ctx.clearRect(0, 0, canvasElement.width, canvasElement.height);
            }
        };
    }
};
