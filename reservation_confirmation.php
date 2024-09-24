<?php
// Start session to retrieve reservation data
session_start();

if (!isset($_SESSION['reservation'])) {
    // Redirect to form if no reservation data is found
    header('Location: index.php');
    exit();
}

// Retrieve reservation data from session
$reservation = $_SESSION['reservation'];

// Clear the reservation data from session
unset($_SESSION['reservation']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/formStyle.css">
</head>
<body>
<div class="container">
    <h1>Reservation Confirmation</h1>
    <div class="alert alert-success">
        <strong>Your reservation has been successfully submitted!</strong>
    </div>
    <h2>Reservation Details</h2>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($reservation['FullName']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($reservation['Email']); ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo htmlspecialchars($reservation['ContactNumber']); ?></td>
            </tr>
            <tr>
                <th>Full Address</th>
                <td><?php echo htmlspecialchars($reservation['FullAddress']); ?></td>
            </tr>
            <tr>
                <th>Number of Guests</th>
                <td><?php echo htmlspecialchars($reservation['NumberofGuests']); ?></td>
            </tr>
            <tr>
                <th>Room Number</th>
                <td><?php echo htmlspecialchars($reservation['roomNum']); ?></td>
            </tr>
            <tr>
                <th>Preferred Date and Time of Stay</th>
                <td><?php echo htmlspecialchars($reservation['PreferredDateTime']); ?></td>
            </tr>
            <tr>
                <th>Room Options</th>
                <td><?php echo htmlspecialchars($reservation['RoomOptions']); ?></td>
            </tr>
            <tr>
                <th>Reservation Date</th>
                <td><?php echo htmlspecialchars($reservation['Date']); ?></td>
            </tr>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Back to Reservation Form</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
