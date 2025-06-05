<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include('db.php');

// Initialize variables
$error_message = "";
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $account_type = $_POST['account_type'];

    // Sanitize input data
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($phone);
    $password = htmlspecialchars($password);
    $confirm_password = htmlspecialchars($confirm_password);

    // Check if passwords match
    if ($password != $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if the email already exists
        try {
            // Check for renter table
            $sql = "SELECT * FROM renters WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Check if the email already exists in renters or owners table
            if ($stmt->rowCount() > 0) {
                $error_message = "This email is already registered. Please use a different email.";
            } else {
                // If the email doesn't exist, insert into the appropriate table
                if ($account_type == "renter") {
                    // Prepare the query for renters
                    $sql = "INSERT INTO renters (name, email, phone_number, password) VALUES (:name, :email, :phone, :password)";
                } else {
                    // Prepare the query for owners
                    $sql = "INSERT INTO owners (name, email, phone_number, password) VALUES (:name, :email, :phone, :password)";
                }

                // Insert into the database
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $password);

                if ($stmt->execute()) {
                    $success_message = "Registration successful! You can now log in.";
                } else {
                    $error_message = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!-- Your HTML code here (without labels) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEase - Register</title>
</head>
<body>

    <!-- Display error message if exists -->
    <?php if (!empty($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>

    <!-- Display success message if exists -->
    <?php if (!empty($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>
    </body>
    </head>