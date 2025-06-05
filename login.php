<?php
session_start();

// Include the database connection file
include('db.php');

// Initialize the error message variable
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];  // 'renter' or 'owner'

    // Sanitize email and password
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($password);

    // Determine the correct table
    if ($account_type === "renter") {
        $sql = "SELECT * FROM renters WHERE email = :email AND password = :password";
    } else {
        $sql = "SELECT * FROM owners WHERE email = :email AND password = :password";
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Store user data in session
            if ($account_type === "renter") {
                $_SESSION['renter_id'] = $user['id'];
                $_SESSION['renter_name'] = $user['name'];
                $_SESSION['renter_email'] = $user['email'];
                header("Location: renter-dashboard.php");
            } else {
                $_SESSION['owner_id'] = $user['id'];
                $_SESSION['owner_name'] = $user['name'];
                $_SESSION['owner_email'] = $user['email'];
                header("Location: owner-dashboard.php");
            }
            exit();
        } else {
            $error_message = "Invalid email or password. Please try again.";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEase - Login</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="background-overlay"></div>
    
    <!-- Car Animation - Keeping this as requested -->
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
    
    <div class="login-container">
        <a href="index.html" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        
        <div class="logo">
            <h1>DriveEase</h1>
        </div>
        
        <div class="tabs">
            <button class="tab-btn active" data-tab="renter">Renter Login</button>
            <button class="tab-btn" data-tab="owner">Owner Login</button>
            <button class="tab-btn" data-tab="register">Register</button>
        </div>

        <!-- Renter Login Form -->
        <div class="tab-content" id="renter-tab">
            <h2>Renter Login</h2>
            <form id="renter-login-form" action="login.php" method="POST">
                <input type="hidden" name="account_type" value="renter">
                <div class="form-group">
                    <label for="renter-email">Email</label>
                    <input type="email" id="renter-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="renter-password">Password</label>
                    <input type="password" id="renter-password" name="password" required>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="renter-remember" name="remember">
                        <label for="renter-remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>

        <!-- Owner Login Form -->
        <div class="tab-content" id="owner-tab">
            <h2>Owner Login</h2>
            <form id="owner-login-form" action="login.php" method="POST">
                <input type="hidden" name="account_type" value="owner">
                <div class="form-group">
                    <label for="owner-email">Email</label>
                    <input type="email" id="owner-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="owner-password">Password</label>
                    <input type="password" id="owner-password" name="password" required>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="owner-remember" name="remember">
                        <label for="owner-remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>

        <!-- Register Tab (Optional for User Registration) -->
        <div class="tab-content" id="register-tab">
            <h2>Create an Account</h2>
            <form id="register-form" action="register.php" method="POST">
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="register-phone">Phone Number</label>
                    <input type="tel" id="register-phone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" required>
                </div>
                
                <div class="form-group">
                    <label for="account-type">Account Type</label>
                    <select id="account-type" name="account_type" required>
                        <option value="">Select account type</option>
                        <option value="renter">Renter</option>
                        <option value="owner">Car Owner</option>
                    </select>
                </div>
                
                <div class="form-options">
                    <div class="terms">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">Create Account</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    this.classList.add('active');

                    const tabId = this.getAttribute('data-tab') + '-tab';
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
