<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reservations - Airline Reservation System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
         body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: #f0f2f5;
        }
        .navbar {
            background-color: #002b5c;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .content-container {
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table {
            margin-top: 20px;
            min-height: 265px;
        }
        th {
            background-color: #002b5c;
            color: white;
        }
       
        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .btn-remove:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="index.html">AirlineReserve</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="../index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../flights.html">Flights</a></li>
                <li class="nav-item"><a class="nav-link" href="../booking.html">Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="../contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_reservation_view.php">Manage Reservations</a></li>
            </ul>
        </div>
    </nav>

<div class="content-container">
    <h3 class="text-center">Manage Reservations</h3>

    <?php
    $conn = new mysqli("localhost", "root", "", "airline_db");
    if ($conn->connect_error) {
        die("<p class='text-danger'>Connection failed: " . $conn->connect_error . "</p>");
    }

    if (isset($_GET['deleted'])) {
        echo "<div class='alert alert-success'>Reservation deleted successfully!</div>";
    }

    $sql = "SELECT id, name, email, passport, flight_id, booking_time FROM bookings ORDER BY booking_time DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'><table class='table table-bordered table-striped'>";
        echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Passport</th><th>Flight ID</th><th>Booking Time</th><th>Action</th></tr></thead><tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['passport']}</td>
                    <td>{$row['flight_id']}</td>
                    <td>{$row['booking_time']}</td>
                    <td>
                        <a href='edit_reservation.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                        <form method='post' action='delete_reservation.php' style='display:inline-block;' onsubmit='return confirm(\"Are you sure you want to delete this reservation?\")'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger btn-sm'>Remove</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-center'>No reservations found.</p>";
    }

    $conn->close();
    ?>
</div>


<footer style="background: #002b5c; color: white; padding: 15px 0; text-align: center; width: 100%; margin-top: 130px;">
    &copy; 2025 Airline Reservation System. All rights reserved.
    </footer>

</body>
</html>
