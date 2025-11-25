<?php
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Setting up database...\n";

    // Users
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at DATETIME,
        password VARCHAR(255) NOT NULL,
        remember_token VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user',
        wallet_balance DECIMAL(10, 2) DEFAULT 0.00,
        created_at DATETIME,
        updated_at DATETIME
    )");
    echo "Users table created.\n";

    // Products
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        stock INTEGER DEFAULT 0,
        created_at DATETIME,
        updated_at DATETIME
    )");
    echo "Products table checked/created.\n";

    // Reviews
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER NOT NULL,
        user_name VARCHAR(255) NOT NULL,
        rating INTEGER NOT NULL,
        comment TEXT NOT NULL,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )");
    echo "Reviews table checked/created.\n";

    // Orders
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        status VARCHAR(20) DEFAULT 'pending',
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    echo "Orders table checked/created.\n";

    // Live Streams
    $pdo->exec("CREATE TABLE IF NOT EXISTS live_streams (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        is_active BOOLEAN DEFAULT 0,
        product_id INTEGER,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
    )");
    echo "Live Streams table checked/created.\n";

    // Sessions
    $pdo->exec("CREATE TABLE IF NOT EXISTS sessions (
        id VARCHAR(255) PRIMARY KEY,
        user_id INTEGER,
        ip_address VARCHAR(45),
        user_agent TEXT,
        payload TEXT NOT NULL,
        last_activity INTEGER NOT NULL
    )");
    echo "Sessions table checked/created.\n";

    // Seed Products if empty
    $count = $pdo->query("SELECT count(*) FROM products")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO products (name, price, description, image, category, stock, created_at, updated_at) VALUES 
        ('Premium Wireless Headphones', 299.99, 'High-fidelity sound with noise cancellation.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80', 'Audio', 50, DATETIME('now'), DATETIME('now')),
        ('Smart Watch Series 5', 399.00, 'Stay connected and healthy.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80', 'Wearables', 30, DATETIME('now'), DATETIME('now')),
        ('UltraBook Pro 15', 1299.00, 'Power for professionals.', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&q=80', 'Computers', 15, DATETIME('now'), DATETIME('now')),
        ('4K Action Camera', 199.50, 'Capture every moment.', 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=500&q=80', 'Cameras', 100, DATETIME('now'), DATETIME('now')),
        ('Gaming Console X', 499.99, 'Next-gen gaming.', 'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=500&q=80', 'Gaming', 25, DATETIME('now'), DATETIME('now'))");
        echo "Products seeded.\n";
    }

    echo "Database setup completed successfully!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
