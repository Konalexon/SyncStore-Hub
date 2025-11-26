<?php
$host = '127.0.0.1';
$db = 'syncstore_hub';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->query("SHOW TABLES LIKE 'badges'");
    echo "Badges Table: " . ($stmt->rowCount() > 0 ? 'Exists' : 'Missing') . "\n";

    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'points'");
    echo "Points Column: " . ($stmt->rowCount() > 0 ? 'Exists' : 'Missing') . "\n";

} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
