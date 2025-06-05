<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['renter_email'])) {
    header("Location: index.html");
    exit();
}

// Check if car_id is provided in the URL
if (isset($_GET['car_id'])) {
    $vehicle_id = $_GET['car_id'];
    $renter_email = $_SESSION['renter_email'];

    try {
        // Insert booking into bookings table
        $stmt = $pdo->prepare("INSERT INTO bookings (vehicle_id, renter_email, status) VALUES (?, ?, 'Booked')");
        $stmt->execute([$vehicle_id, $renter_email]);

        // Update the vehicle's availability status to 'Unavailable'
        $update = $pdo->prepare("UPDATE vehicles SET availability_status = 'Unavailable' WHERE id = ?");
        $update->execute([$vehicle_id]);

        // Show confirmation message
        echo "<div style='text-align:center; color:green; padding:20px;'>";
        echo "<h2>Booking Confirmed!</h2>";
        echo "<p>Your booking for vehicle ID <strong>$vehicle_id</strong> was successful.</p>";
        echo "<p><strong>Status:</strong> Booked</p>";
        echo "<a href='renter-dashboard.php' style='font-size: 18px; color: #4CAF50; text-decoration: none;'>Go to Dashboard</a>";
        echo "</div>";
    } catch (PDOException $e) {
        echo "<div style='text-align:center; color:red;'>Error: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div style='text-align:center; color:red;'>Invalid booking request. No car_id provided.</div>";
}
?>
