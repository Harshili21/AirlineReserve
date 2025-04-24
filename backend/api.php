<?php
// Connect to MySQL database
$conn = new mysqli("localhost", "root", "", "airline_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_POST['action'] == 'contactUs') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Print data for debugging
    // print_r($_POST);
    
    // Store the message into the database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    file_put_contents("debug_log.txt", print_r($_POST, true));

    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    exit;
}

// Handle booking form submission
if ($_POST['action'] == 'bookFlight') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $passport = $_POST['passport'];
    $flight_id = $_POST['flight_id'];

    // Insert booking data into the bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, passport, flight_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $passport, $flight_id);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Booking successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    exit;
}
?>