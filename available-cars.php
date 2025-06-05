<?php
session_start();
include 'db.php'; // Your database connection

// Assuming you stored the renter's name in a session variable during login
if (isset($_SESSION['renter_name'])) {
    $renter_name = $_SESSION['renter_name'];
} else {
    // Handle the case where renter_name is not set, maybe redirect to login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link rel="stylesheet" href="renter-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="background-overlay"></div>

    <!-- Car Animation -->
    <div class="car-animation-container">
        <div class="car">
            <div class="car-body">
                <div class="car-top"></div>
                <div class="car-bottom"></div>
                <div class="wheel wheel-left"></div>
                <div class="wheel wheel-right"></div>
                <div class="headlight"></div>
                <div class="taillight"></div>
            </div>
        </div>
    </div>

    <header>
        <div class="logo">
            <h1>DriveEase</h1>
        </div>
        <nav>
            <ul>
                <li><a href="renter-dashboard.php" class="active">Find Cars</a></li>
                <li><a href="#">My Bookings</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="fas fa-user-circle"></i> <?php echo $renter_name; ?>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="#"><i class="fas fa-user"></i> Profile</a>
                        <a href="#"><i class="fas fa-history"></i> Rental History</a>
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
                        <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h2>Available Cars</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Vehicle Name</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Rent Per Day</th>
                    <th>Action</th>
                </tr>
                <?php
                try {
                    // Fetch available vehicles
                    $stmt = $pdo->query("SELECT * FROM vehicles WHERE availability_status = 'available'");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vehicle_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['vehicle_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['registration_number']) . "</td>";
                        echo "<td>₹" . htmlspecialchars($row['rent_per_day']) . "</td>";
                        echo "<td>
                                <form action='payment.html' method='get'>
                                    <input type='hidden' name='car_id' value='" . htmlspecialchars($row['id']) . "'>
                                    <button type='submit'>Book Now</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='6'>Error fetching vehicles: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </table>
        </section>
    </main>

    <!-- Car animation styling -->
    <style>
        .search-section h2 {
            font-size: 36px;
            font-weight: 700;
            color: #2a3f75;
            text-align: center;
            margin-top: 30px;
            text-shadow: 2px 2px #ccc;
        }

        body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    color: #fff;
}


        .car-animation-container {
            position: fixed;
            bottom: 0;
            left: -300px;
            width: 100px; /* reduced size */
            animation: drive 10s linear infinite;
        }

        .car-animation-container .car {
            position: relative;
            width: 100%;
        }

        .car-animation-container .car-body {
            width: 80px; /* reduced car length */
            background-color: #333;
            height: 40px;
            border-radius: 10px;
        }

        .car-animation-container .wheel {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #000;
            border-radius: 50%;
            bottom: -10px;
        }

        .car-animation-container .wheel-left {
            left: 10px;
        }

        .car-animation-container .wheel-right {
            right: 10px;
        }

        @keyframes drive {
            0% { left: -300px; }
            50% { left: 50%; transform: translateX(-50%); }
            100% { left: 100%; }
        }

        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.95);
            color: #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: center;
        }

        th {
            background-color: #2a3f75;
            color: white;
        }

        td button {
            padding: 8px 14px;
            background-color: #5b67a3;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #3a4271;
        }
    </style>
</body>
</html>
