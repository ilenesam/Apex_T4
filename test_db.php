<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8mb4", "root", "");
    echo "✅ Connected to database successfully.";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
