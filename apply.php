<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HumanDesire";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $region = $_POST["region"];
    $district = $_POST["district"];
    $street = $_POST["street"];
    $company_name = $_POST["company_name"];
    $instagram = $_POST["instagram"];
    $categoryy = $_POST["categoryy"];
    $business = $_POST["business"];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO apply (first_name, last_name, email, phone_number, region, district, street, company_name, instagram, categoryy, business) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sssssssssss", $first_name, $last_name, $email, $phone_number, $region, $district, $street, $company_name, $instagram, $categoryy, $business);

    if ($stmt->execute()) {
        header("Location: finish_apply.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
