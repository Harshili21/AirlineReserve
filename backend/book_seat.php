<?php
$conn = new mysqli("localhost", "root", "", "airline_db");
$flight_id = $_POST['flight_id'];
$seat_number = $_POST['seat_number'];

// Check availability
$check = $conn->query("SELECT status FROM seats WHERE flight_id = $flight_id AND seat_number = '$seat_number'");
$row = $check->fetch_assoc();

if ($row['status'] === 'booked') {
    echo "Seat already booked!";
    exit;
}

// Book the seat
$conn->query("UPDATE seats SET status = 'booked' WHERE flight_id = $flight_id AND seat_number = '$seat_number'");
echo "Seat booked successfully!";
?>
