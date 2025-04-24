<?php
$conn = new mysqli("localhost", "root", "", "airline_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM bookings WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Reservation not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style> body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f0f2f5;
        }
        .navbar {
            background-color: #002b5c;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="index.html">AirlineReserve</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="flights.html">Flights</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.html">Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_reservation_view.php">Manage Reservations</a></li>
            </ul>
        </div>
    </nav>
<div class="container mt-5">
    <h2>Edit Reservation</h2>
    <form method="post" action="update_reservation.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
        </div>
        <div class="form-group">
            <label>Passport</label>
            <input type="text" name="passport" class="form-control" value="<?= $row['passport'] ?>" required>
        </div>
        <div class="form-group">
            <label>Flight ID</label>
            <input type="text" name="flight_id" class="form-control" value="<?= $row['flight_id'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Reservation</button>
        <a href="manage_reservation_view.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>


<footer style="background: #002b5c; color: white; padding: 15px 0; text-align: center; width: 100%;margin-top: 110px; ">
        &copy; 2025 Airline Reservation System. All rights reserved.
    </footer>
</body>
</html>
