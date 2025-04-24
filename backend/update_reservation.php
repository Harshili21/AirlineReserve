<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "airline_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $passport = $conn->real_escape_string($_POST['passport']);
    $flight_id = $conn->real_escape_string($_POST['flight_id']);

    $sql = "UPDATE bookings SET name='$name', email='$email', passport='$passport', flight_id='$flight_id' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_reservation_view.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
