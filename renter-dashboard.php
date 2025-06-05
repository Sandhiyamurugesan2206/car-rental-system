<?php
// Include database connection
include 'db.php';

// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['renter_email'])) {
    $renter_email = $_SESSION['renter_email']; // Assuming the email is stored in the session

    try {
        $query = "SELECT name FROM renters WHERE email = :renter_email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':renter_email', $renter_email, PDO::PARAM_STR);
        $stmt->execute();
        $renter = $stmt->fetch(PDO::FETCH_ASSOC);
        $renter_name = $renter ? $renter['name'] : 'Guest';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEase - Renter Dashboard</title>
    <link rel="stylesheet" href="renter-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        header .logout-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        @media screen and (max-width: 768px) {
            .logout-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="background-overlay"></div>

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
                <li><a href="#" class="active">Find Cars</a></li>
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
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="fas fa-question-circle"></i> Help
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="#"><i class="fas fa-book"></i> FAQs</a>
                        <a href="#"><i class="fas fa-headset"></i> Support</a>
                        <a href="#"><i class="fas fa-info-circle"></i> About Us</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="logout-wrapper">
            <button class="logout-btn" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
        <div class="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Find Your Perfect Ride</h1>
                <p>Explore our wide range of vehicles for your next adventure</p>
            </div>
        </section>

        <section class="search-section">
            <div class="search-container">
                <h2>Search Available Cars</h2>
                <div class="search-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pickup-location">
                                <i class="fas fa-map-marker-alt"></i> Pickup Location
                            </label>
                            <select id="pickup-location" required>
                                <option value="">Select location</option>
                                <option value="Karur city center">Karur city center</option>
                                <option value="Aravakurichi">Aravakurichi</option>
                                <option value="Karur">Karur</option>
                                <option value="Thalavapalayam">Thalavapalayam</option>
                                <option value="Pugalur">Pugalur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row date-row">
                        <div class="form-group">
                            <label for="pickup-date">
                                <i class="fas fa-calendar-alt"></i> Pickup Date
                            </label>
                            <input type="date" id="pickup-date" required>
                        </div>
                        <div class="form-group">
                            <label for="return-date">
                                <i class="fas fa-calendar-alt"></i> Return Date
                            </label>
                            <input type="date" id="return-date" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group duration-display">
                            <label>
                                <i class="fas fa-clock"></i> Rental Duration
                            </label>
                            <div class="duration-badge">
                                <span id="duration-days">0 days</span>
                            </div>
                        </div>
                        <div class="form-group search-button-container">
                            <button id="search-button" class="btn-search">
                                <i class="fas fa-search"></i> Search Cars
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>DriveEase</h3>
                <p>Drive Your Dreams, Rent with Ease</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 DriveEase. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Dropdown toggle
        document.querySelector('.dropdown-toggle').addEventListener('click', function () {
            this.nextElementSibling.classList.toggle('show');
        });

        // Date logic
        const pickupDateInput = document.getElementById('pickup-date');
        const returnDateInput = document.getElementById('return-date');
        const durationDisplay = document.getElementById('duration-days');

        const today = new Date();
        const todayFormatted = today.toISOString().split('T')[0];
        pickupDateInput.setAttribute('min', todayFormatted);
        returnDateInput.setAttribute('min', todayFormatted);

        function updateDuration() {
            if (pickupDateInput.value && returnDateInput.value) {
                const pickupDate = new Date(pickupDateInput.value);
                const returnDate = new Date(returnDateInput.value);

                if (returnDate >= pickupDate) {
                    const diffTime = Math.abs(returnDate - pickupDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    durationDisplay.textContent = diffDays + (diffDays === 1 ? ' day' : ' days');
                } else {
                    durationDisplay.textContent = 'Invalid dates';
                }
            } else {
                durationDisplay.textContent = '0 days';
            }
        }

        pickupDateInput.addEventListener('change', function () {
            returnDateInput.setAttribute('min', this.value);
            updateDuration();
        });

        returnDateInput.addEventListener('change', updateDuration);

        document.getElementById('search-button').addEventListener('click', function () {
            const pickupLocation = document.getElementById('pickup-location').value;
            const pickupDate = pickupDateInput.value;
            const returnDate = returnDateInput.value;

            if (pickupLocation && pickupDate && returnDate) {
                window.location.href = `available-cars.php?pickup_location=${pickupLocation}&pickup_date=${pickupDate}&return_date=${returnDate}`;
            } else {
                alert('Please fill in all search fields');
            }
        });
    </script>
</body>
</html>
