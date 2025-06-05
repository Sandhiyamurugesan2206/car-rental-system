<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['renter_id'])) {
    header('Location: login.html');
    exit();
}

// Fetch renter name
$renter_id = $_SESSION['renter_id'];
$query = "SELECT name FROM renters WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $renter_id);
$stmt->execute();
$stmt->bind_result($renter_name);
$stmt->fetch();
$stmt->close();
?>
