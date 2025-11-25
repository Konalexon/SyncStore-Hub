# SyncStore-Hub 🛒🎥

**SyncStore-Hub** is a next-generation e-commerce platform that blends traditional online shopping with the excitement of **Live Commerce**. It features a real-time video shopping experience, dynamic bidding, and an AI-powered admin panel.

![Live Shop Experience](file:///C:/Users/konal/.gemini/antigravity/brain/795c4926-64bd-444d-81f3-7b4de33e180c/live_page_fixed_1764028113701.png)

## 🚀 Key Features

### 🔴 Live Shopping Experience
- **Real-Time Streaming**: Simulated high-quality video stream (120 FPS, 720p) using `BroadcastChannel` for low-latency local broadcasting.
- **Interactive Overlay**: Glassmorphism-style product cards that appear during the stream.
- **Live Bidding**: Users can place bids in real-time with dynamic price updates.
- **Auction Timer**: Synchronized countdown timer for limited-time offers.
- **Live Chat**: Real-time chat for user engagement (simulated).

### 🛠️ Admin Command Center
- **Live Dashboard**: Dedicated control panel to manage the stream, toggle webcam, and push products to the live feed.
- **Active Product Tracking**: See exactly what users are seeing with a synchronized "Currently Auctioning" display.
- **Magic AI Tools**:
    - **Auto-Description**: Generates compelling product descriptions based on name and category.
    - **Smart Pricing**: Suggests prices based on product tier (e.g., "Pro" adds value).
    - **Auto-Image**: Fetches relevant high-quality images from Unsplash automatically.

### 🛍️ Modern E-Commerce
- **Dynamic Catalog**: Filterable product grid with category and price range controls.
- **Cart System**: Fully functional cart with "Add to Cart" animations.
- **Responsive Design**: Built with Bootstrap 5 and custom CSS for a premium, mobile-friendly look.

## 📸 Screenshots

| Admin Live Dashboard | Catalog View |
|:--------------------:|:------------:|
| ![Admin Dashboard](file:///C:/Users/konal/.gemini/antigravity/brain/795c4926-64bd-444d-81f3-7b4de33e180c/admin_live_active_product_retry_1764027636987.png) | ![Catalog](file:///C:/Users/konal/.gemini/antigravity/brain/795c4926-64bd-444d-81f3-7b4de33e180c/catalog_verified_final_1764019789271.png) |

## 💻 Tech Stack

- **Framework**: [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend**: Blade Templates, Bootstrap 5, Vanilla JavaScript
- **Database**: SQLite (Default) / MySQL compatible
- **Real-Time**: HTML5 `BroadcastChannel` API, Web Workers

## 🛠️ Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/SyncStore-Hub.git
    cd SyncStore-Hub
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Setup**
    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```
    *Or use the `/fix-data` route to auto-seed the database.*

5.  **Build Assets**
    ```bash
    npm run build
    ```

6.  **Run the Application**
    ```bash
    php artisan serve
    ```

## 🌟 Usage

1.  **Access the Store**: Go to `http://localhost:8000`.
2.  **Admin Panel**: Log in at `/login` (Default: `admin@syncstore.com` / `password`).
3.  **Start a Stream**:
    - Go to **Admin > Live Stream**.
    - Allow Camera Access.
    - Select a product and click **Go Live**.
4.  **Watch Live**: Open `/live` in a separate tab/window to see the stream and overlay in action.

---

*Built with ❤️ by the SyncStore Team.*
