<?php
function build_calendar($month, $year) {
    $mysqli = new mysqli('localhost', 'root', '', 'renatosplace_db');

    // Check the database connection
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Prepare the SQL query
    $stmt = $mysqli->prepare("SELECT DATE FROM renatos_db WHERE MONTH(DATE) = ? AND YEAR(DATE) = ?");
    $stmt->bind_param('ss', $month, $year);
    $reservation = array();

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if 'DATE' key exists in the result set
                if (isset($row['DATE'])) {
                    $reservation[] = $row['DATE'];
                } else {
                    // Handle the case where 'DATE' is not found
                    echo "Warning: Undefined Array Key 'DATE'";
                }
            }
        }

        $stmt->close();
    } else {
        // Handle query execution errors
        echo "Error executing query: " . $stmt->error;
    }

    // Convert month name to month number if necessary
    if (!is_numeric($month)) {
        $month = date('m', strtotime($month . ' 1 ' . $year));
    }

    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');

    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2>$monthName $year</h2>";
    $calendar .= "<a class='btn1 btn-xs btn-success' href='?month=" . date('m', mktime(0, 0, 0, $month-1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month-1, 1, $year)) . "'>Previous Month</a> ";
    $calendar .= " <a class='btn1 btn-xs btn-danger' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
    $calendar .= "<a class='btn1 btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month+1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month+1, 1, $year)) . "'>Next Month</a></center><br>";

    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='calendarheader'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";

        $dayname = strtolower(date('l', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? "today" : "";
        
        if ($date < date('Y-m-d')) {
            $calendar .= "<td><h4>$currentDay</h4> <button class='btn1 btn-danger btn-xs' disabled>N/A</button>";
        } elseif (in_array($date, $reservation)) {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn1 btn-danger btn-xs'> <span class='glyphicon glyphicon-lock'></span> Already Booked</button>";
        } else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='reservation.php?date=" . $date . "' class='btn1 btn-success btn-xs'> <span class='glyphicon glyphicon-ok'></span> Book Now</a>";
        }

        $calendar .= "</td>";
        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($l = 0; $l < $remainingDays; $calendar .= "<td class='empty'></td>", $l++);
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";
    echo $calendar;
}
?>

   <?php require('Css/homeStyle.css')?>
  
  <!-- Calendar -->

  <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="calendar" style="background:#3498db;border:none;color:#fff">
                <h1>Calendar</h1>
                </div>
                <?php
                    $dateComponents = getdate();
                    if(isset($_GET['month']) && isset($_GET['year'])){
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    }else{
                        $month = $dateComponents['month'];
                        $year = $dateComponents['year'];
                    }
                    echo build_calendar($month, $year);
                ?>
            
            </div>
        </div>
    </div>

    <!-- end -->
