<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json"); // Ensure JSON response

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "humanDesire";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : "";

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit();
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO User (name, email, message) VALUES (?, ?, ?)");
    
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "SQL preparation error: " . $conn->error]);
        exit();
    }

    // Bind parameters
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thank you for messaging us. We will reply to you soon."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to send message. Please try again."]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>