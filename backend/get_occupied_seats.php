<?php
include 'backend/db.php'; 
$flight_id = $_GET['flight_id'] ?? 1;
$sql = "SELECT selected_seat FROM bookings WHERE flight_id = $flight_id";
$result = $conn->query($sql);

$occupied_seats = [];
while ($row = $result->fetch_assoc()) {
    $seats = explode(",", $row['selected_seat']);
    $occupied_seats = array_merge($occupied_seats, $seats);
}

header('Content-Type: application/json');
echo json_encode($occupied_seats);
?>
