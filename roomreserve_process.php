<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get check-in and check-out dates from POST request
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_option_value = $_POST['room_option'];
    $adult_guest = (int)$_POST['adult_guest'];
    $child_guest = (int)$_POST['child_guest'];


      // Mapping the value to corresponding text
      $room_options = [
        "1" => "Daytime",
        "2" => "Overnight",
        "3" => "Staycation"
    ];

     // Get the text corresponding to the selected value
     $room_option_text = $room_options[$room_option_value];

    // Store dates in session
    $_SESSION['check_in'] = $check_in;
    $_SESSION['check_out'] = $check_out;
    $_SESSION['room_option_text'] = $room_option_text;
    $_SESSION['adult_guest'] = $adult_guest;
    $_SESSION['child_guest'] = $child_guest;

    // Calculate the total number of guests
    $_SESSION['total_guests'] = $adult_guest + $child_guest;

    // Redirect to another page or show success message
    header("Location: roomReservation.php");
    exit();
    }
?>