-- Add points column if not exists (using a procedure to handle 'if not exists' for columns in MySQL 5.7+)
-- For simplicity in XAMPP (MariaDB), we can try simple ALTER and ignore error if exists, or use a block.
-- Let's just try ALTER, if it fails it fails (likely already exists if migration ran).
ALTER TABLE users ADD COLUMN points INT DEFAULT 0;

CREATE TABLE IF NOT EXISTS badges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    threshold INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS user_badges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    badge_id BIGINT UNSIGNED NOT NULL,
    awarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
);

-- Seed Badges
INSERT INTO badges (name, icon, description, type, threshold, created_at, updated_at) VALUES
('Newbie', '🔰', 'Welcome to the community!', 'register', 1, NOW(), NOW()),
('Chatterbox', '🗣️', 'Sent 10 messages.', 'chat', 10, NOW(), NOW()),
('Big Spender', '💸', 'Spent over $500.', 'spend', 500, NOW(), NOW()),
('Winner', '🏆', 'Won your first auction.', 'win', 1, NOW(), NOW());
