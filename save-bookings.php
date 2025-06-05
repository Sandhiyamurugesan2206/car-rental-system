<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = $_POST['vehicle_id'];
    $renter_email = $_POST['renter_email'];

    try {
        // Insert booking record
        $stmt = $pdo->prepare("INSERT INTO bookings (vehicle_id, renter_email) VALUES (?, ?)");
        $stmt->execute([$vehicle_id, $renter_email]);

        // Mark vehicle as unavailable
        $update = $pdo->prepare("UPDATE vehicles SET availability_status = 'Unavailable' WHERE id = ?");
        $update->execute([$vehicle_id]);

        echo "Booking saved successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
