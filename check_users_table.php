<?php
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $stmt = $pdo->query("PRAGMA table_info(users);");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo $col['name'] . " (" . $col['type'] . ")\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
