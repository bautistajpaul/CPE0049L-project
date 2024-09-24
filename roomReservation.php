<?php
if(isset($_GET['date'])){
    $date = $_GET['date'];
}

if(isset($_POST['submit'])){

    $fname = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['ContactNumber'];
    $address = $_POST['FullAddress'];
    $guest = $_POST['NumberofGuests'];
    $roomnum = $_POST['roomNum'];
    $dateOfStay = $_POST['PreferredDateofStay'];
    $roolOption = $_POST['RoomOptions'];

    if ($guest > 6) {
        $message = "<div class='alert alert-danger'>The maximum number of guests per room is 6. Please adjust your reservation.</div>";
    } else {
        $conn = new mysqli('localhost', 'root', '', 'renatosplace_db');

        $sql = "INSERT INTO renatos_db(FullName, Email, ContactNumber, FullAddress, NumberofGuests, PreferredDateofStay, RoolOptions, Date) 
                VALUES('$fname', '$email', '$phone', '$address', '$guest','$roomnum', '$dateOfStay', '$roolOption', '$date')";

        if($conn->query($sql)){
            $message = "<div class='alert alert-success'>Successfully booked!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Please try again.</div>";
        }
    }
}

session_start();
// if (isset($_SESSION['check_in']) && isset($_SESSION['check_out'])) {
    $check_in = $_SESSION['check_in'];
    $check_out = $_SESSION['check_out'];
    $room_option_text = $_SESSION['room_option_text'];
    $adult_guest = $_SESSION['adult_guest'];
    $child_guest = $_SESSION['child_guest'];
    $total_guests = $_SESSION['total_guests'];
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renatos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/formStyle.css">
</head>
<body>
       <div class="container">
        <h1>Room Reservation</h1>
        <?php echo isset($message) ? $message : ''; ?>
        <form action="" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="">Full Name</label>
                <input type="text" name="FullName" required>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="Email" required>
            </div>
            <div class="form-group">
                <label for="">Contact Number</label>
                <input type="text" name="ContactNumber" required pattern="[0-9]{10}" title="Please enter a valid contact number with 10 digits">
            </div>
            <div class="form-group">
                <label for="">Full Address</label>
                <input type="text" name="FullAddress" required>
            </div>
            <div class="form-group">
                <label for="">Number of Guests</label>
                <input type="number" name="NumberofGuests" value="<?php echo $total_guests;?>" required>
            </div>
            <div class="form-group">
                <label for="">Room Number</label>
                <input type="number" name="roomNum" required>
            </div>
            <div class="form-group">
                <label for="preferredDateTime">Preferred Date and Time of Stay</label>
                <input type="datetime-local" id="preferredDateTime" name="PreferredDateTime" value="<?php echo $check_in;?>" required min="">
            </div>

            <div class="form-group">
                <label for="">Room Options</label>
                <select name="RoomOptions" required>
                    <option value="1" <?php echo (isset($_SESSION['room_option_text']) && $_SESSION['room_option_text'] == 'Daytime') ? 'selected' : ''; ?>>Daytime</option>
                    <option value="2" <?php echo (isset($_SESSION['room_option_text']) && $_SESSION['room_option_text'] == 'Overnight') ? 'selected' : ''; ?>>Overnight</option>
                    <option value="3" <?php echo (isset($_SESSION['room_option_text']) && $_SESSION['room_option_text'] == 'Staycation') ? 'selected' : ''; ?>>Staycation</option>
                </select>
            </div>

            <h3>Terms and Conditions</h3>
            <p><strong>Before proceeding with your reservation, please carefully review our terms and conditions. Your agreement to these terms is required for completing the booking process.</strong></p>
            <div class="terms-container">
                <input type="checkbox" id="termsAgreeMain" name="agree" required>
                <label for="termsAgreeMain">I have read and agree with the <span class="terms-link">Terms and Conditions</span></label>
            </div>

            <br>

            
            <a href="confirm.php" class="btn btn-primary" id="proceedToPayment" style="display: none;">Proceed to Payment</a>
            <a href="home.php" class="btn-success">Back</a>
        </form>

        <!-- Modal -->
        <div id="termsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="termsModalLabel">Terms and Conditions of Renato’s Place Private Resort and Events</h4>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <p><strong></strong></p>
            <p><strong>1. Reservation</strong></p>
            <p>Reservations can be made online through our website, Facebook page, or by contacting our reservation team via phone or email. A confirmation email will be sent upon successful booking.</p>
            <p><strong>2. Payment</strong></p>
            <p>A deposit must be made at the time of reservation. The remaining balance will be paid upon arrival at the resort or at the end of accommodation.</p>
            <p><strong>3. Cancellation Policy</strong></p>
            <p>Strictly no cancellations, but re-scheduling made within 30 days prior to the check-in date will be able to reschedule. Cancellations/reschedule made more than 30 days will result in forfeiture of the deposit.</p>
            <p><strong>4. Guest Responsibilities</strong></p>
            <p>Guests are expected to respect the property and other guests. Any damage to the property caused by the guest will be charged to the guest's account.</p>
            <p><strong>5. Liability</strong></p>
            <p>The resort is not responsible for any loss, damage, or injury sustained by guests during their stay.</p>
            <p><strong>6. Privacy Policy</strong></p>
            <p>We respect your privacy and will not share your personal information without your consent.</p>
            <p><strong>7. Changes of Terms and Conditions</strong></p>
            <p>We reserve the right to modify these terms and conditions at any time, any changes will be posted on our page.</p>
            <p>By making a reservation at Renato’s Place Private Resort and Events, you agree to abide by these terms and conditions.</p>
        </div>
        <div class="modal-footer">
            <div class="terms-agreement">
                <input type="checkbox" id="termsAgreeModal" required>
                <label for="termsAgreeModal">I have read and agree to the terms and conditions.</label>
            </div>
            <button class="close-modal">Close</button>
        </div>
    </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/formRoom.js"></script>
</body>
</html>