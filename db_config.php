<?php
// Database connection details
$servername = "localhost"; // Change if not using localhost
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "login_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} ?>