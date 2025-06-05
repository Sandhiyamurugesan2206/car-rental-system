<?php
session_start();
if (!isset($_SESSION['owner_id'])) {
    header("Location: login.html");
    exit();
}
$owner_name = $_SESSION['owner_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - DriveEase</title>
    <link rel="stylesheet" href="owner-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
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
                    <li class="active">
                        <a href="owner-dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
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
                <a href="logout.php">
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
                    
                    <div class="user-profile">
                        <img src="https://via.placeholder.com/40" alt="User">
                        <span><?= htmlspecialchars($owner_name) ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </header>
            
            <div class="dashboard-content">
                <div class="welcome-banner">
                    <div class="welcome-text">
                        <h2>Welcome back, <?= htmlspecialchars($owner_name) ?>!</h2>
                        <p>Here's what's happening with your vehicles today.</p>
                    </div>
                    <div class="welcome-actions">
                        <a href="owner-add-vehicle.php" class="btn-primary">
                            <i class="fas fa-plus"></i> Add New Vehicle
                        </a>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Active Vehicles</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Current Bookings</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>₹45,750</h3>
                            <p>This Month's Earnings</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-info">
                            <h3>4.8</h3>
                            <p>Average Rating</p>
                        </div>
                    </div>
                </div>
                
                <div class="section-heading">
                    <h2>Your Listed Vehicles</h2>
                    <a href="owner-vehicles.html" class="view-all">View All Vehicles</a>
                </div>
                
                <div class="vehicles-grid">
                    <!-- Vehicle cards go here (unchanged) -->
                </div>
                
                <div class="section-heading">
                    <h2>Recent Bookings</h2>
                    <a href="owner-bookings.html" class="view-all">View All Bookings</a>
                </div>
                
                <div class="bookings-table-container">
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Vehicle</th>
                                <th>Customer</th>
                                <th>Dates</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Booking rows go here (unchanged) -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
