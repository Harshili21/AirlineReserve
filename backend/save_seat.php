<?php
include 'backend/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat = $_POST['seat'];
    $flight_id = 1; // Use your actual flight ID logic

    $stmt = $conn->prepare("INSERT INTO booked_seats (flight_id, seat_no) VALUES (?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $flight_id, $seat);
    $stmt->execute();

    echo "Seat confirmed!";
}
?>
