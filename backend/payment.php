<?php
// Connect to your database
$conn = new mysqli("localhost", "root", "", "airline_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST
$name = $_POST['name'];
$email = $_POST['email'];
$flight_id = $_POST['flight_id'];

// Insert booking before redirecting to PayPal
$stmt = $conn->prepare("INSERT INTO bookings (name, email, flight_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $email, $flight_id);

if ($stmt->execute()) {
    // Success: You can now proceed to PayPal
    header("Location: payment-gateway.php"); // Or continue to build the PayPal form here
} else {
    echo "Error saving booking: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<form action="payment.php" method="post">
    <input type="text" name="name" required>
    <input type="email" name="email" required>
    <input type="hidden" name="flight_id" value="123">
    <button type="submit">Proceed to Payment</button>
</form>
