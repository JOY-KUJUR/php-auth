<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<?php
// Include database configuration
include 'db_config.php';

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    // Check if username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($pass, $hashed_password)) {
            // Store user authentication data in session
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $user;

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit(); // Stop script execution after redirect
        } else {
            // Invalid password
            echo "<h1>Login failed!</h1>";
            echo "<p>Invalid username or password.</p>";
            header("Location: login.html");
            exit(); // Stop script execution after redirect
        }
    } else {
        // Username does not exist
        echo "<h1>Login failed!</h1>";
        echo "<p>User not found.</p>";
        header("Location: login.html");
        exit(); // Stop script execution after redirect
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No data received.";
}
?>

</body>
</html>
