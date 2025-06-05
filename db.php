<?php
// db.php - Database connection file

$host = 'localhost';      // Database host
$dbname = 'car_rental'; // Database name
$username = 'root';       // Database username (default for XAMPP)
$password = '';           // Database password (default for XAMPP is empty)

// Create PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
