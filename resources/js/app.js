import './bootstrap';
import '../sass/app.scss';
import * as bootstrap from 'bootstrap';

// Make bootstrap available globally
window.bootstrap = bootstrap;

// Add to Cart Functionality
window.addToCart = function (productId) {
    // Create Toast Container if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }

    // Create Toast
    const toastHtml = `
        <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i> Product added to cart!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    const toastElement = document.createElement('div');
    toastElement.innerHTML = toastHtml;
    const toastNode = toastElement.firstElementChild;
    toastContainer.appendChild(toastNode);

    const toast = new bootstrap.Toast(toastNode);
    toast.show();

    // Update Cart Badge
    const badge = document.querySelector('.bi-cart3').nextElementSibling;
    if (badge) {
        let count = parseInt(badge.innerText);
        badge.innerText = count + 1;

        // Animate badge
        badge.classList.add('bg-warning');
        setTimeout(() => badge.classList.remove('bg-warning'), 200);
    }
};

// Live Chat Simulation
const chatBox = document.getElementById('chatBox');
if (chatBox) {
    const messages = [
        { user: 'Alex K.', text: 'Is this available in black?', color: 'text-primary' },
        { user: 'Maria S.', text: 'Just bought one! 🎉', color: 'text-success' },
        { user: 'Moderator', text: 'Limited stock remaining! Grab yours now.', color: 'text-danger' },
        { user: 'John D.', text: 'Does it work with Mac?', color: 'text-info' },
    ];

    setInterval(() => {
        const randomMsg = messages[Math.floor(Math.random() * messages.length)];
        const msgHtml = `
            <div class="mb-2 fade-in">
                <span class="fw-bold ${randomMsg.color}">${randomMsg.user}</span>
                <span class="text-secondary">${randomMsg.text}</span>
            </div>
        `;
        chatBox.insertAdjacentHTML('beforeend', msgHtml);
        chatBox.scrollTop = chatBox.scrollHeight;
    }, 5000);
}
