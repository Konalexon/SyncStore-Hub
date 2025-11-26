USE syncstore_hub;

-- 1. Drop Tables to ensure clean slate (reverse order of dependencies)
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS live_streams;
DROP TABLE IF EXISTS wishlists;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- 2. Create Tables

-- Users
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    role VARCHAR(255) DEFAULT 'user',
    wallet_balance DECIMAL(10, 2) DEFAULT 0.00,
    address VARCHAR(255) NULL,
    city VARCHAR(255) NULL,
    zip VARCHAR(255) NULL,
    country VARCHAR(255) NULL,
    is_banned TINYINT(1) DEFAULT 0
);

-- Products
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Orders
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(255) DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items
CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Wishlists
CREATE TABLE wishlists (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_user_product (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Live Streams
CREATE TABLE live_streams (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    is_active TINYINT(1) DEFAULT 0,
    product_id BIGINT UNSIGNED NULL,
    pinned_message VARCHAR(255) NULL,
    auction_end_time TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Reviews (Linked to User now)
CREATE TABLE reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    rating INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Contact Messages (New Table)
CREATE TABLE contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 3. Insert Data

-- Users
INSERT INTO users (name, email, password, role, wallet_balance, address, city, zip, country, created_at, updated_at) VALUES
('Admin User', 'admin@syncstore.com', '$2y$12$K.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x', 'admin', 1000.00, 'Admin HQ', 'Tech City', '00000', 'USA', NOW(), NOW()),
('Alice Johnson', 'alice@example.com', '$2y$12$K.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x', 'user', 150.00, '123 Maple St', 'Springfield', '62704', 'USA', NOW(), NOW()),
('Bob Smith', 'bob@example.com', '$2y$12$K.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x', 'user', 0.00, '456 Oak Ave', 'Metropolis', '10001', 'USA', NOW(), NOW()),
('Charlie Brown', 'charlie@example.com', '$2y$12$K.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x.x', 'user', 1200.50, '789 Pine Ln', 'Gotham', '53540', 'USA', NOW(), NOW());

-- Products
INSERT INTO products (name, description, price, image, category, stock, created_at, updated_at) VALUES
('Premium Wireless Headphones', 'High quality sound.', 299.99, 'headphones.jpg', 'Audio', 50, NOW(), NOW()),
('Smart Watch Series 5', 'Stay connected.', 399.00, 'smartwatch.jpg', 'Wearables', 30, NOW(), NOW()),
('UltraBook Pro 15', 'Power and portability.', 1299.00, 'laptop.jpg', 'Computers', 15, NOW(), NOW()),
('4K Action Camera', 'Capture your adventures.', 199.50, 'camera.jpg', 'Cameras', 100, NOW(), NOW()),
('Gaming Console X', 'Next-gen gaming.', 499.99, 'console.jpg', 'Gaming', 25, NOW(), NOW());

-- Orders
-- Order 1: Alice (id 2)
INSERT INTO orders (user_id, total_amount, status, created_at, updated_at) VALUES (2, 299.99, 'completed', NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 5 DAY);
SET @order1_id = LAST_INSERT_ID();
INSERT INTO order_items (order_id, product_id, quantity, price, created_at, updated_at) VALUES (@order1_id, 1, 1, 299.99, NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 5 DAY);

-- Order 2: Charlie (id 4)
INSERT INTO orders (user_id, total_amount, status, created_at, updated_at) VALUES (4, 1798.99, 'completed', NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY);
SET @order2_id = LAST_INSERT_ID();
INSERT INTO order_items (order_id, product_id, quantity, price, created_at, updated_at) VALUES 
(@order2_id, 3, 1, 1299.00, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),
(@order2_id, 5, 1, 499.99, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY);

-- Order 3: Bob (id 3)
INSERT INTO orders (user_id, total_amount, status, created_at, updated_at) VALUES (3, 399.00, 'pending', NOW(), NOW());
SET @order3_id = LAST_INSERT_ID();
INSERT INTO order_items (order_id, product_id, quantity, price, created_at, updated_at) VALUES (@order3_id, 2, 1, 399.00, NOW(), NOW());

-- Wishlists
INSERT INTO wishlists (user_id, product_id, created_at, updated_at) VALUES
(2, 3, NOW(), NOW()), -- Alice wants Laptop
(2, 4, NOW(), NOW()), -- Alice wants Camera
(3, 1, NOW(), NOW()), -- Bob wants Headphones
(4, 2, NOW(), NOW()); -- Charlie wants Watch

-- Reviews (Linked to Users)
INSERT INTO reviews (product_id, user_id, rating, comment, created_at, updated_at) VALUES
(1, 2, 5, 'Amazing sound quality! Best headphones I ever owned.', NOW() - INTERVAL 4 DAY, NOW() - INTERVAL 4 DAY), -- Alice
(3, 4, 4, 'Great laptop, but a bit heavy.', NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY), -- Charlie
(5, 4, 5, 'This console is a beast! 8K gaming is real.', NOW() - INTERVAL 10 DAY, NOW() - INTERVAL 10 DAY); -- Charlie

-- Contact Messages
INSERT INTO contact_messages (name, email, subject, message, created_at, updated_at) VALUES
('John Doe', 'john.doe@external.com', 'Partnership Inquiry', 'Hi, I would like to discuss a partnership opportunity with SyncStore.', NOW() - INTERVAL 3 DAY, NOW() - INTERVAL 3 DAY),
('Alice Johnson', 'alice@example.com', 'Order Issue', 'I have not received my tracking number yet for Order #1.', NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),
('Guest User', 'guest@random.com', 'Product Question', 'Do you ship to Canada?', NOW() - INTERVAL 6 HOUR, NOW() - INTERVAL 6 HOUR);

-- Live Stream
INSERT INTO live_streams (title, is_active, product_id, pinned_message, created_at, updated_at) VALUES
('Mega Tech Sale!', 0, NULL, 'Welcome to the stream! Big discounts today.', NOW(), NOW());
