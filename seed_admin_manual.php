<?php
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Seeding Admin and Cleaning Data...\n";

    // 1. Create Admin User
    $password = password_hash('password', PASSWORD_BCRYPT);
    $email = 'admin@syncstore.com';

    // Check if exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $pdo->prepare("UPDATE users SET role = 'admin', password = ? WHERE email = ?")->execute([$password, $email]);
        echo "Admin user updated.\n";
    } else {
        $pdo->prepare("INSERT INTO users (name, email, password, role, wallet_balance, created_at, updated_at) VALUES (?, ?, ?, 'admin', 1000.00, datetime('now'), datetime('now'))")
            ->execute(['Admin User', $email, $password]);
        echo "Admin user created.\n";
    }

    // 2. Truncate Products
    $pdo->exec("DELETE FROM products");
    // Reset auto-increment
    $pdo->exec("DELETE FROM sqlite_sequence WHERE name='products'");
    echo "Products table cleared.\n";

    echo "Done!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
