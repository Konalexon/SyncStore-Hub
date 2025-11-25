CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at DATETIME,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
);

CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    stock INTEGER DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);

CREATE TABLE IF NOT EXISTS reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    rating INTEGER NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INTEGER,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

INSERT INTO products (name, price, description, image, category, stock, created_at, updated_at) VALUES 
('Premium Wireless Headphones Pro X', 299.99, 'Immerse yourself in music quality sound with our flagship wireless headphones. Engineered for audiophiles and professionals.', 'headphones.jpg', 'Audio', 50, DATETIME('now'), DATETIME('now')),
('Smart Watch Series 5', 399.00, 'Stay connected, active, and healthy with the new Smart Watch Series 5. Features an always-on Retina display.', 'smartwatch.jpg', 'Wearables', 30, DATETIME('now'), DATETIME('now')),
('UltraBook Pro 15', 1299.00, 'Power and portability in one package. The UltraBook Pro 15 features the latest processor and a stunning 4K display.', 'laptop.jpg', 'Computers', 15, DATETIME('now'), DATETIME('now')),
('4K Action Camera', 199.50, 'Capture your adventures in stunning 4K resolution. Waterproof, shockproof, and ready for anything.', 'camera.jpg', 'Cameras', 100, DATETIME('now'), DATETIME('now')),
('Gaming Console X', 499.99, 'Experience next-gen gaming with the Console X. 8K support, 120fps, and a library of exclusive titles.', 'console.jpg', 'Gaming', 25, DATETIME('now'), DATETIME('now')),
('Designer Sunglasses', 150.00, 'Stylish protection for your eyes. UV400 protection and premium materials.', 'sunglasses.jpg', 'Accessories', 200, DATETIME('now'), DATETIME('now')),
('Leather Handbag', 89.99, 'Elegant and spacious leather handbag. Perfect for everyday use or special occasions.', 'handbag.jpg', 'Fashion', 40, DATETIME('now'), DATETIME('now'));
