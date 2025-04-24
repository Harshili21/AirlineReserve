<?php
session_start();
include 'backend/db.php';  // Ensure this file contains your database connection

// Mock email for testing (remove when login is set up)
$_SESSION['email'] = 'testuser@example.com'; // This will be replaced with the logged-in user's email

$email = $_SESSION['email'] ?? null;

if (!$email) {
    echo "Please log in to view reservations.";
    exit;
}

// Cancel booking if the user clicks "Cancel"
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);

    // Check if cancel_id is a valid integer and user email matches
    $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND email = ?");
    $stmt->bind_param("is", $cancel_id, $email);
    $stmt->execute();

    // Confirm cancellation and redirect
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Booking has been cancelled.'); window.location.href='manage_reservations.php';</script>";
    } else {
        echo "<script>alert('Failed to cancel the booking. Please try again later.'); window.location.href='manage_reservations.php';</script>";
    }
    exit;
}

// Fetch bookings for this user
$sql = "SELECT b.id AS booking_id, b.name, b.email, b.passport, b.booking_time, b.status,
               f.airline, f.origin, f.destination, f.departure_date, f.departure_time
        FROM bookings b
        JOIN flights f ON b.flight_id = f.id
        WHERE b.email = '$email'
        ORDER BY b.booking_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table thead {
            background-color: #1c2c59;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .cancelled {
            color: red;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Manage Your Reservations</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Name</th>
                    <th>Passport</th>
                    <th>Flight</th>
                    <th>From → To</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Booking Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?= $row['booking_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['passport'] ?></td>
                        <td><?= $row['airline'] ?></td>
                        <td><?= $row['origin'] ?> → <?= $row['destination'] ?></td>
                        <td><?= $row['departure_date'] ?></td>
                        <td><?= $row['departure_time'] ?></td>
                        <td><?= $row['booking_time'] ?></td>
                        <td>
                            <?php if ($row['status'] === 'cancelled'): ?>
                                <span class="cancelled">This booking has been cancelled.</span>
                            <?php else: ?>
                                <a href="?cancel_id=<?= $row['booking_id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel Booking</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">You have no reservations.</div>
    <?php endif; ?>
</div>

</body>
</html>
