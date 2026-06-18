<?php
// Database connection settings
// Change your_dbname, your_user, and your_pass
$dsn  = "mysql:host=localhost;dbname=your_dbname;charset=utf8mb4";
$user = "your_user";
$pass = "your_pass";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
