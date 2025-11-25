<?php
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table';");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . implode(", ", $tables) . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
