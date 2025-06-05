<?php
session_start(); // Start the session

// Include the database connection
include('db.php'); // Make sure the path to db.php is correct

// Check if the owner is logged in and retrieve their owner ID
if (isset($_SESSION['owner_id'])) {
    $owner_id = $_SESSION['owner_id'];
} else {
    // Redirect to login page if not logged in
    header("Location: owner-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset($_POST['vehicle_name']) && !empty($_POST['vehicle_name']) &&
        isset($_POST['registration_number']) && !empty($_POST['registration_number']) &&
        isset($_POST['seating_capacity']) && !empty($_POST['seating_capacity']) &&
        isset($_POST['rent_per_day']) && !empty($_POST['rent_per_day']) &&
        isset($_POST['location']) && !empty($_POST['location']) &&
        isset($_POST['vehicle_type']) && !empty($_POST['vehicle_type']) &&
        isset($_POST['availability_status']) && !empty($_POST['availability_status'])) {

        // Sanitize and assign values to variables
        $vehicle_name = htmlspecialchars($_POST['vehicle_name']);
        $vehicle_type = htmlspecialchars($_POST['vehicle_type']);
        $registration_number = htmlspecialchars($_POST['registration_number']);
        $seating_capacity = htmlspecialchars($_POST['seating_capacity']);
        $rent_per_day = htmlspecialchars($_POST['rent_per_day']);
        $location = htmlspecialchars($_POST['location']);
        $availability_status = htmlspecialchars($_POST['availability_status']); // Availability status from form

        // Check if the registration number already exists in the database
        $check_sql = "SELECT COUNT(*) FROM vehicles WHERE registration_number = :registration_number";
        $stmt = $pdo->prepare($check_sql);
        $stmt->bindParam(':registration_number', $registration_number);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        // If the registration number exists, show an error message
        if ($count > 0) {
            echo "Error: The registration number already exists in the database.";
        } else {
            // Prepare the SQL insert statement using PDO
            $sql = "INSERT INTO vehicles (owner_id, vehicle_name, vehicle_type, registration_number, seating_capacity, rent_per_day, location, availability_status)
                    VALUES (:owner_id, :vehicle_name, :vehicle_type, :registration_number, :seating_capacity, :rent_per_day, :location, :availability_status)";
            
            // Prepare and bind parameters
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':owner_id', $owner_id);
            $stmt->bindParam(':vehicle_name', $vehicle_name);
            $stmt->bindParam(':vehicle_type', $vehicle_type);
            $stmt->bindParam(':registration_number', $registration_number);
            $stmt->bindParam(':seating_capacity', $seating_capacity);
            $stmt->bindParam(':rent_per_day', $rent_per_day);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':availability_status', $availability_status);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Vehicle added successfully!";
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Vehicle - DriveEase</title>
    <link rel="stylesheet" href="owner-dashboard.css">
    <link rel="stylesheet" href="owner-add-vehicle.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div style="position: absolute; top: 25px; right: 80px; font-weight: 500;">
    <i class="fas fa-user" style="margin-right: 5px;"></i> <?php echo htmlspecialchars($_SESSION['owner_name']); ?>
</div>

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <h1>DriveEase</h1>
            </div>
            <p>Owner Dashboard</p>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="owner-dashboard.html">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="owner-vehicles.html">
                        <i class="fas fa-car"></i>
                        <span>My Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="owner-bookings.html">
                        <i class="fas fa-calendar-check"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="owner-earnings.html">
                        <i class="fas fa-rupee-sign"></i>
                        <span>Earnings</span>
                    </a>
                </li>
                <li>
                    <a href="owner-reviews.html">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
                <li>
                    <a href="owner-settings.html">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <a href="index.html">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="dashboard-header">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            
            <div class="header-actions">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </div>
            </div>
        </header>
        
        <div class="dashboard-content">
            <div class="page-header">
                <h1>Add New Vehicle</h1>
                <p>List your vehicle on DriveEase and start earning</p>
            </div>
            
            <div class="add-vehicle-form-container">
                <form action="owner-add-vehicle.php" method="POST" class="add-vehicle-form">
                    <div class="form-section">
                        <h2>Basic Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="vehicle-name">Vehicle Name</label>
                                <input type="text" id="vehicle-name" name="vehicle_name" placeholder="e.g. Maruti Suzuki">
                            </div>
                            
                            <div class="form-group">
                                <label for="vehicle-type">Vehicle Type</label>
                                <input type="text" id="vehicle-type" name="vehicle_type" placeholder="e.g. Sedan, SUV">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="registration-number">Registration Number</label>
                                <input type="text" id="registration-number" name="registration_number" placeholder="e.g. TN 39 AB 1234">
                            </div>
                            
                            <div class="form-group">
                                <label for="seating-capacity">Seating Capacity</label>
                                <input type="number" id="seating-capacity" name="seating_capacity" placeholder="e.g. 5">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="rent-per-day">Rent Per Day (₹)</label>
                                <input type="number" id="rent-per-day" name="rent_per_day" placeholder="e.g. 1500">
                            </div>
                            
                            <div class="form-group">
                                <label for="vehicle-location">Location</label>
                                <select id="vehicle-location" name="location">
                                    <option value="karur-city">Karur City Center</option>
                                    <option value="thalavapalayam">Thalavapalayam</option>
                                    <option value="kulithalai">Kulithalai</option>
                                    <option value="pugalur">Pugalur</option>
                                    <option value="aravakurichi">Aravakurichi</option>
                                </select>
                            </div>
                        </div>

                        <!-- Availability Status -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="availability-status">Availability Status</label>
                                <select id="availability-status" name="availability_status">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Add Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar toggle
        const sidebarToggle = document.querySelector('.mobile-sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }
    });
</script>
</body>
</html>
