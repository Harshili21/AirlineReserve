<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "";
$db = "airline_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$passport = $_POST['passport'];
$flight = $_POST['flight'];

$stmt = $conn->prepare("INSERT INTO bookings (name, email, passport, flight_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $passport, $flight);

if ($stmt->execute()) {
    echo "Booking confirmed!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


