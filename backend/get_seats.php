<?php
$conn = new mysqli("localhost", "root", "", "airline_db");

$flight_id = $_GET['flight_id']; // From query param
$result = $conn->query("SELECT seat_number, status FROM seats WHERE flight_id = $flight_id");

$seats = [];
while ($row = $result->fetch_assoc()) {
    $seats[] = $row;
}
echo json_encode($seats);
?>
