<?php
session_start();
include 'db.php'; // Database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_seat = $_POST['selected_seat']; // Get the selected seat(s)

    // Assuming user is logged in and we have their email
    $email = $_SESSION['email']; // Get user email from session

    // You can customize the flight and booking ID logic here, if needed
    $flight_id = 1; // Sample flight ID (this should come from user's flight selection)
    $booking_id = 123; // Sample booking ID (this should be dynamic, based on the user's booking)

    // Save selected seat to the database (assuming a 'seats' table or adding a column to the 'bookings' table)
    $stmt = $conn->prepare("UPDATE bookings SET selected_seat = ? WHERE id = ? AND email = ?");
    $stmt->bind_param("sis", $selected_seat, $booking_id, $email);
    $stmt->execute();

    // Provide feedback to the user
    if ($stmt->affected_rows > 0) {
        echo "Your seat has been selected successfully!";
    } else {
        echo "There was an issue with saving your seat. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
