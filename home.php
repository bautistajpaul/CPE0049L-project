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
            $calendar .= "<td><h4>$currentDay</h4> <button class='btn1 btn-danger btn-xs' disabled>Not Available</button>";
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

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renatos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/homeStyle.css">
    <link rel="stylesheet" href="css/roomStyle.css">

</head>

<body>
    <!--header-->

    <header class="header">

        <a href="" class="logo" data-image="image/RenatosLOGO.png"></i>Austin-Tanious Residences</a>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About</a>     
            <a href="#gallery">Gallery</a>
            <a href="#room">Rooms</a>
            <!-- <a href="#resort">Resort</a>
            <a href="#event">Events</a> -->
            <a href="#faq">Faq</a>
            <a href="reservation.php" class="btn">Login</a>
        </nav>

        <div id="menu-btn" class="fas fa-bars"></div>
    </header>
    <!--end-->

    <!--home-->

    <section class="home" id="home">

        <div class="swiper home-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide slide" style="background: url(image/scholarHomeBG.png) no-repeat">
                    <div class="content">
                        <h3>Scholar’s Haven in University Belt</h3>
                        <a href="#offer" class="btn">Check a place now</a>
                    </div>
                </div>
                <div class="swiper-slide slide" style="background: url(image/scholarHomeBG.png) no-repeat">
                    <div class="content">
                        <h3>Scholar’s Haven in University Belt</h3>
                        <a href="#offer" class="btn">Check a place now</a>
                    </div>
                </div>
                <div class="swiper-slide slide" style="background: url(image/scholarHomeBG.png) no-repeat">
                    <div class="content">
                        <h3>Scholar’s Haven in University Belt</h3>
                        <a href="#offer" class="btn">Check a place now</a>
                    </div>
                </div>
                <div class="swiper-slide slide" style="background: url(image/scholarHomeBG.png) no-repeat">
                    <div class="content">
                        <h3>Scholar’s Haven in University Belt</h3>
                        <a href="#offer" class="btn">Check a place now</a>
                    </div>
                </div>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>  
    </section>

    <!--end-->

    <!-- Calendar -->

    <!-- <div class="container">
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
    </div> -->

    <!-- end -->

    <!--about-->

    <section class="about" id="about">

        <div class="row">

            <div class="image">
                <img src="image/about.jpg" alt="">
            </div>

            <div class="content">
                <h3>about us</h3>
                <p>Renato’s Place Private Resort and Events commonly known as RENATO’S PLACE was opened to all 
                interested parties both in private and public on October 28, 2020. It started with a vision and 
                mission to be one of the industry innovators that can transform ordinary moments into extraordinary 
                memories.</p>
                <p>It is located at Inside Noel’s Village Brgy. Dolores Taytay, Rizal. At first, Renato’s Place 
                kick-off its first Private Resort that can accommodate up to 80 guests. This family-friendly resort offers 
                relaxation and detoxifying atmosphere from the hustle-bustle of city-life. You will be welcomed by warm 
                accommodations and instagrammable sceneries. Get refreshed by the infinity pool, mini pool and heated jacuzzi. 
                Relax in the pool-side loungers, a gazebo, and Venue Hall. Renato’s Place has 4 suite rooms, Event Hall and 
                Café Restaurant. This place was made with a mission to accommodate guest that will gather from afar and need 
                time to relax and just have a get away from a busy life out of the city.</p>
                <p>On year 2021, Renatos Place Pavilion was born. This becomes the heart of Renato’s Place. 
                    Inside this gem is It’s an event place with elegant spaces can accommodate up to 250 guest, 
                    high ceiling designs with stylish chandelier and marvelous walls; stage; airconditioned couple 
                    lounge and restrooms; spacious seating area for multi-purpose functions and welcoming lobby for 
                    everyone.</p>
            </div>
        </div>
    </section>

    <section class="mission" id="mission">
        <div class="row1">
            <div class="content1">
                <h5>mission</h5>
                <p>Renato’s Place Private Resort and Events mission is to provide authentic 
                hospitality. We make a difference in the lives of people we touch every day. 
                Our definition of hospitality.</p>
                <p>To provide true and rich hospitality. We make a difference in the lives of 
                those we touch every day – that is our definition of hospitality. We do this 
                in an environment that respects all people and all ideas. We do it in an efficient 
                way that leads to superior results.</p>
            </div>
        </div>
    </section>

    <section class="vision" id="vision">
        <div class="row2">
            <div class="content2">
                <h5>vision</h5>
                <p>We are creating an everlasting dream holiday in harmony with nature and an 
                experience of traditional Filipino hospitality that is extraordinary and memorable.</p>
                <p>Our vision is to establish Renato’s Place Private Resort and Events as a prestigious 
                and globally recognized Resort and Venue Brand.</p>
                <p>We build life-long guest relationships by delivering exquisite services and fulfilling 
                their ultimate dream Staycation and Events.</p>

            </div>
        </div>
    </section>
   
    <!--end-->

    <!--gallery-->

    <section class="gallery" id="gallery">

        <h1 class="heading">gallery</h1>

        <div class="swiper gallery-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide slide">
                    <img src="image/gallery1.jpg" alt="Gallery Image 1">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery2.jpg" alt="Gallery Image 2">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery3.jpg" alt="Gallery Image 3">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery4.jpg" alt="Gallery Image 4">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery5.jpg" alt="Gallery Image 5">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery6.jpg" alt="Gallery Image 6">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery7.jpg" alt="Gallery Image 7">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery8.jpg" alt="Gallery Image 8">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery9.jpg" alt="Gallery Image 9">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery10.jpg" alt="Gallery Image 10">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery11.jpg" alt="Gallery Image 11">
                </div>

                <div class="swiper-slide slide">
                    <img src="image/gallery12.jpg" alt="Gallery Image 12">
                </div>

            </div>

        </div>

    </section>

    <!-- Gallery Modal Structure -->
    <div id="galleryModal" class="modal">
    <span class="gallery-close">&times;</span>
    <div class="modal-content">
        <div class="gallery-image-grid">
        </div>
    </div>
    </div>

   <!-- script for gallery grid view -->
   <script>
    // Get the modal element
    var galleryModal = document.getElementById("galleryModal");
    var galleryModalContent = document.querySelector(".gallery-image-grid");

    // Get the close button
    var galleryCloseBtn = document.querySelector(".gallery-close");

    // Add click event to all images in the gallery
    var galleryImages = document.querySelectorAll(".gallery img");
    galleryImages.forEach(image => {
    image.addEventListener("click", function() {
        // Open the modal
        galleryModal.style.display = "block";

        // Clear existing images in the modal grid
        galleryModalContent.innerHTML = "";

        // Add all images from the gallery section to the modal grid
        galleryImages.forEach(img => {
            var imgSrc = img.src;
            var imgElement = document.createElement("img");
            imgElement.src = imgSrc;
            galleryModalContent.appendChild(imgElement);
        });

        // Add additional images not in the gallery section
        var additionalImages = [
            'image/events/1.jpg',
            'image/events/2.jpg',
            'image/events/3.jpg',
            'image/events/4.jpg',
            'image/events/5.jpg',
            'image/events/6.jpg',
            'image/events/7.jpg',
            'image/events/8.jpg',
            'image/events/9.jpg',
            'image/events/10.jpg',
            'image/events/12.jpg',
            'image/events/13.jpg',
            'image/events/14.jpg',
            'image/events/15.jpg',
            'image/events/16.jpg',
            // Add more image paths here
        ];

        additionalImages.forEach(src => {
            var imgElement = document.createElement("img");
            imgElement.src = src;
            galleryModalContent.appendChild(imgElement);
        });
    });
});

// Close the modal when the close button is clicked
galleryCloseBtn.addEventListener("click", function() {
    galleryModal.style.display = "none";
});

// Close the modal when clicking outside the modal content
window.addEventListener("click", function(event) {
    if (event.target == galleryModal) {
        galleryModal.style.display = "none";
    }
});

   </script>

    <!--end-->

    <!-- Offer Section -->
    <section class="offer" id="offer">

      <h1 class="heading">our offers</h1>

        <div class="swiper offer-slider">
          <div class="swiper-wrapper">
            <div class="swiper-slide slide">
                <img src="image/offer1.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer1.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer2.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer2.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer3.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer3.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer4.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer4.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer5.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer5.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer6.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer6.jpg"></i>
                </div>
            </div>

            <div class="swiper-slide slide">
                <img src="image/offer7.jpg" alt="">
                <div class="icon">
                    <i class="fas fa-magnifying-glass-plus" data-image="image/offer7.jpg"></i>
                </div>
            </div>
        </div>
    </div>
    </section>

    <!-- Modal for Image View -->
    <div id="imageModal" class="image-modal">
    <span class="close-image-modal">&times;</span>
    <img class="modal-content-image" id="modalImage">
    </div>

    <script>
    // Get the modal element
    var imageModal = document.getElementById("imageModal");

    // Get the image element inside the modal
    var modalImage = document.getElementById("modalImage");

    // Get the <span> element that closes the modal
    var closeImageModal = document.querySelector(".close-image-modal");

    // Get all icons with the class "fas fa-magnifying-glass-plus"
    var magnifyIcons = document.querySelectorAll(".fas.fa-magnifying-glass-plus");

    // Attach click event listeners to each icon
    magnifyIcons.forEach(function(icon) {
        icon.onclick = function() {
            var imageUrl = icon.getAttribute("data-image");
            modalImage.src = imageUrl;
            imageModal.style.display = "block";
        };
    });

    // When the user clicks on <span> (x), close the modal
    closeImageModal.onclick = function() {
        imageModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == imageModal) {
            imageModal.style.display = "none";
        }
    }
    </script>

    <!--end-->

    <!-- rooms -->
    <section class="room" id="room">
    <form action="roomreserve_process.php" method="post">
        <h1 class="heading">Our Rooms</h1>
        <div class="container">
            <div class="row">
                <div class="filters">
                    <nav class="filter-nav">
                        <h4>Filters</h4>
                        <button class="toggle-button" type="button">
                            &#9776; Toggle Filters
                        </button>
                        <div class="filter-content">
                            <div class="filter-section">
                                <h5>Check Availability</h5>
                                <label class="form-label">Check-in</label>
                                <input type="datetime-local" class="form-input" id="check-in" name="check_in" required>
                                <label class="form-label">Check-out</label>
                                <input type="datetime-local" class="form-input" id="check-out" name="check_out" required>
                            </div>
                            <div class="filter-section">
                                <h5>Room Options</h5>
                                <div>
                                    <select name="room_option" required>
                                    <option value="1">Daytime</option>
                                    <option value="2">Overnight</option>
                                    <option value="3">Staycation</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="filter-section">
                                <h5>Facilities</h5>
                                <div>
                                    <input type="checkbox" id="f1" class="form-check-input">
                                    <label for="f1">Facility one</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="f2" class="form-check-input">
                                    <label for="f2">Facility two</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="f3" class="form-check-input">
                                    <label for="f3">Facility three</label>
                                </div>
                            </div>
                            <div class="filter-section">
                                <h5>Guests</h5>
                                <div class="guest-inputs">
                                    <div>
                                        <label class="form-label">Adults</label>
                                        <input type="number" name="adult_guest" class="form-input">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" name="child_guest" class="form-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="rooms">
                    <div class="room-card">
                        <div class="room-content">
                            <div class="room-image">
                                <img src="image/room1.jpg" alt="Suite room">
                            </div>
                            <div class="room-info">
                                <h5 class="room-title">Suite room for 22 hours</h5>
                                <div class="room-features">
                                    <h6>Full Kitchen Amenities</h6>
                                    <span class="badge">2 Rooms</span>
                                    <span class="badge">1 Bathroom</span>
                                </div>
                                <div class="room-facilities">
                                    <h6>Facilities</h6>
                                    <span class="badge">AC</span>
                                    <span class="badge">WiFi</span>
                                    <span class="badge">TV</span>
                                </div>
                                <div class="room-guests">
                                    <h6>Guests</h6>
                                    <span class="badge">5 Adults</span>
                                    <span class="badge">1 Child</span>
                                </div>
                            </div>
                            <div class="room-actions">
                                <h6 class="room-price">PHP 3,500.00</h6>
                                <button type="submit" class="btn">Book Now</button>
                                <!-- <a href="roomReservation.php" class="btn">Book Now</a> -->
                                <a href="" class="btn2">More Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="room-card">
                        <div class="room-content">
                            <div class="room-image">
                                <img src="image/room3.jpg" alt="Suite room">
                            </div>
                            <div class="room-info">
                                <h5 class="room-title">Suite room for 12 hours</h5>
                                <div class="room-features">
                                    <h6>Features</h6>
                                    <span class="badge">2 Rooms</span>
                                    <span class="badge">1 Bathroom</span>
                                </div>
                                <div class="room-facilities">
                                    <h6>Facilities</h6>
                                    <span class="badge">AC</span>
                                    <span class="badge">WiFi</span>
                                    <span class="badge">TV</span>
                                </div>
                                <div class="room-guests">
                                    <h6>Guests</h6>
                                    <span class="badge">5 Adults</span>
                                    <span class="badge">1 Child</span>
                                </div>
                            </div>
                            <div class="room-actions">
                                <h6 class="room-price">PHP 2,500.00</h6>
                                <button type="submit" class="btn">Book Now</button>
                                <!-- <a href="roomReservation.php" class="btn">Book Now</a> -->
                                <a href="" class="btn2">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

    <!-- Modal Structure -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modal-room-title">Room Title</h2>
            <p id="modal-room-description">Detailed information about the room will go here.</p>
        </div>
    </div>

    <!-- Room modal script -->
     <script>
        document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const closeBtn = document.querySelector('.close-btn');
    const moreDetailsButtons = document.querySelectorAll('.btn2');

    function showModal(title, description) {
        document.getElementById('modal-room-title').textContent = title;
        document.getElementById('modal-room-description').textContent = description;
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    moreDetailsButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const roomCard = button.closest('.room-card');
            const roomTitle = roomCard.querySelector('.room-title').textContent;
            const roomDescription = roomCard.querySelector('.room-info').innerText;
            showModal(roomTitle, roomDescription);
        });
    });

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
});

     </script>

    <!-- Room calendar script -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const now = new Date().toISOString().slice(0, 16);
            document.getElementById('check-in').setAttribute('min', now);
            document.getElementById('check-out').setAttribute('min', now);
        });
    </script>
    <!--end-->

    <!--events-->

    <section class="event" id="event">

    <h1 class="heading">events</h1>

    <div class="swiper room-slider">

        <div class="swiper-wrapper">

            <!-- Wedding Events -->
            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/wedding.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>wedding events</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="wedding">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Debut Events -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/debut.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>debut events</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="debut">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Kiddie Party -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/kiddie party.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>kiddie party</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="kiddie">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Birthday Party -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/birthday.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>birthday party</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="birthday">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Corporate Events -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/corporate.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>corporate events</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="corporate">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Pool Party -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/pool party.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>pool party</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="pool">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>

            <!-- Other Events -->

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="image/other.jpg" alt="">
                    <a href="reservation.php"></a>
                </div>
                <div class="content">
                    <h3>other events</h3>
                    <p>No matter the occasion, we can help you create a memorable event. Whether it's an anniversary, a reunion, or any other gathering, our customized services ensure a unique and enjoyable experience. </p>
                    <div class="card">
                        <h4 class="open-event-modal" data-event="other">More Details</h4>
                    </div>
                    <a href="reservation.php" class="btn">book now</a>
                </div>
            </div>
        </div>
             <div class="swiper-pagination">
        </div>
    </div>
    </section>

    <!-- Event Modal -->
    <div id="event-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEventModal">&times;</span>
        <h3 id="event-title">Event Details</h3>
        <p id="event-description">Details about the event go here. You can customize this 
        section to display information relevant to each event.</p>
    </div>
    </div>

    <script>
    var eventModal = document.getElementById("event-modal");
    var closeEventModalBtn = document.getElementById("closeEventModal");
    var openEventModalBtns = document.querySelectorAll(".open-event-modal");

    var eventTitle = document.getElementById("event-title");
    var eventDescription = document.getElementById("event-description");

    var eventDetails = {
        "wedding": {
            "title": "Wedding Events",
            "description": "Our wedding events offer a perfect setting for your special day, complete with customized services to make your dream wedding a reality."
        },
        "debut": {
            "title": "Debut Events",
            "description": "Celebrate your 18th birthday in style with our debut packages, designed to create unforgettable memories for you and your guests."
        },
        "kiddie": {
            "title": "Kiddie Party",
            "description": "Make your child's special day truly memorable with our fun-filled kiddie parties! We offer a variety of themes, games, and entertainment options that will delight kids and parents alike."
        },
        "birthday": {
            "title": "Birthday Party",
            "description": "Whether it's a milestone birthday or a simple celebration, our birthday parties are designed to create joyful and lasting memories. Enjoy customized decorations, delicious treats, and entertainment that suits your style."
        },
        "corporate": {
            "title": "Corporate Events",
            "description": "Host your next corporate event in a professional and sophisticated environment. From conferences to team-building activities, we offer tailored services to ensure your event is a success."
        },
        "pool": {
            "title": "Pool Party",
            "description": "Dive into fun with our lively pool parties! Perfect for summer celebrations, our pool parties offer a refreshing way to enjoy great music, food, and company in a vibrant atmosphere."
        },
        "other": {
            "title": "Other Events",
            "description": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus iusto illo "
        },
        // Add more events here...
    };

    openEventModalBtns.forEach(function(btn) {
        btn.onclick = function() {
            var eventType = btn.getAttribute("data-event");
            eventTitle.textContent = eventDetails[eventType].title;
            eventDescription.textContent = eventDetails[eventType].description;
            eventModal.style.display = "flex";
        }
    });

    closeEventModalBtn.onclick = function() {
        eventModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == eventModal) {
            eventModal.style.display = "none";
        }
    }
    </script>

    <!--end-->

    <!-- services -->

    <section class="services">

        <h1 class="heading">services</h1>

        <div class="box-container">

            <div class="box">
                <img src="image/service1.png" alt="">
                <h3>swimming pool</h3>
            </div>

            <div class="box">
                <img src="image/service2.png" alt="">
                <h3>food & drinks</h3>
            </div>
        
            <div class="box">
                <img src="image/service3.png" alt="">
                <h3>bar</h3>
            </div>
        </div>
 
    </section>
    <!--end-->

    <!-- Affiliate Caterers -->
    <section class="affiliates">
        <h1 class="heading">LIST OF ACCREDITED SUPPLIERS CATERING</h1>

        <div class="box-container">

            <div class="box">
                <img src="image/catering.png" alt="">
                <h3 class="modal-trigger" data-modal="modal1">Affiliate Caterers</h3>
                <!-- Box content moved to modal -->
            </div>

            <div class="box">
                <img src="image/supplier.png" alt="">
                <h3 class="modal-trigger" data-modal="modal2">LIGHTS AND SOUND</h3>
                <!-- Box content moved to modal -->
            </div>

            <div class="box">
                <img src="image/service3.png" alt="">
                <h3 class="modal-trigger" data-modal="modal3">Bar</h3>
                <!-- Box content moved to modal -->
            </div>

            <div class="box">
                <img src="image/dessert icon.png" alt="">
                <h3 class="modal-trigger" data-modal="modal4">Grazing Table</h3>
                <!-- Box content moved to modal -->
            </div>
        </div>
    </section>

     <!-- Modal Structure -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById("myModal");
            const modalBody = document.getElementById("modal-body");
            const closeButton = document.querySelector(".close");

            // Modal content for each section
            const modalContents = {
                modal1: `
                    <h3><a href="https://www.facebook.com/densolscatering" target="_blank">DENSOL'S CATERING</a></h3>
                    <p>Contact-Number:</p>
                    <p>
                        <a href="tel:09656051741"><i class="fas fa-phone"></i> 09656051741</a><br>
                        <a href="tel:09983941602"><i class="fas fa-phone"></i> 09983941602</a><br>
                        <a href="tel:09361732001"><i class="fas fa-phone"></i> 09361732001</a><br>
                        <a href="tel:0282869256"><i class="fas fa-phone"></i> HOTLINE 02-82869256</a>
                    </p>
                    <h3><a href="https://www.facebook.com/chefmariascatering" target="_blank">CHEF MARIA'S CATERING</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09285211340"><i class="fas fa-phone"></i> 0928-5211340</a></p>
                    <h3><a href="https://www.facebook.com/madriagacatering" target="_blank">MADRIAGA CATERING</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09109477722"><i class="fas fa-phone"></i> 0910-9477722</a></p>
                    <h3><a href="https://www.facebook.com/sacbcateringservice" target="_blank">SAC-B CATERING</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:279589260"><i class="fas fa-phone"></i> 279589260</a></p>
                    <h3><a href="https://www.facebook.com/weddingcateringbyhizons?mibextid=ZbWKwL" target="_blank">HIZON'S CATERING</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09665046540"><i class="fas fa-phone"></i> 0966-5046540</a></p>
                `,
                modal2: `
                    <h3><a href="https://www.facebook.com/orangeandstringsstudio?mibextid=ZbWKwL" target="_blank">Orange and string studio</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 09194184035</a></p>
                    <h3><a href="https://www.facebook.com/profile.php?id=100064086667821&mibextid=ZbWKwL" target="_blank">JGR</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 0915-7964743</a></p>
                    <h3><a href="https://www.facebook.com/profile.php?id=100083036905420&mibextid=ZbWKwL" target="_blank">Rave</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 0945-5141763</a></p>
                `,
                modal3: `
                    <h3><a href="https://www.facebook.com/Renatoscafefoodandbar?mibextid=ZbWKwL" target="_blank">Renato's Cafe</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 0961-0203503</a></p>
                `,
                modal4: `
                    <h3><a href="https://www.facebook.com/donutwallbyhazel?mibextid=ZbWKwL" target="_blank">Donut wall by hazel</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 09056671086</a></p>
                    <h3><a href="https://www.facebook.com/TheYolkk?mibextid=ZbWKwL" target="_blank">The Yolk Coffee and Snack Bar</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 0955-7496398</a></p>
                    <h3><a href="https://www.facebook.com/kountakoyaki?mibextid=ZbWKwL" target="_blank">(Koun Takoyaki)</a></h3>
                    <p>Contact-Number:</p>
                    <p><a href="tel:09194184035"><i class="fas fa-phone"></i> 0915-2356078</a></p>
                `
            };

            // Event listeners for opening modals
            document.querySelectorAll('.modal-trigger').forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const modalId = trigger.getAttribute('data-modal');
                    modalBody.innerHTML = modalContents[modalId];
                    modal.style.display = "block";
                });
            });

            // Event listener for closing the modal
            closeButton.addEventListener('click', () => {
                modal.style.display = "none";
            });

            // Close the modal when clicking outside of it
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>

    <!--end-->

    <!--faq-->

    <section class="faqs" id="faq">

        <h1 class="heading">frequently asked question</h1>

        <div class="row">

            <div class="iamge">
                <img src="image/faq.gif" alt="">
            </div>

            <div class="content">

                <div class="box active">
                    <h3>what are payment methods?</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi libero temporibus nostrum </p> 
                </div>

                <div class="box">
                    <h3>what are payment methods?</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi libero temporibus nostrum </p> 
                </div>

                <div class="box">
                    <h3>what are payment methods?</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi libero temporibus nostrum </p> 
                </div>

                <div class="box">
                    <h3>what are payment methods?</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi libero temporibus nostrum </p> 
                </div>

                <div class="box">
                    <h3>what are payment methods?</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi libero temporibus nostrum </p> 
                </div>

            </div>

        </div>

    </section>
    
    <!--end-->

    <!--footer-->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>contact info</h3>
                <a href="tel:09173270833"><i class="fas fa-phone"></i> 0917-327-0833 - JULS</a>
                <a href="tel:+63285514405"> <i class="fas fa-phone"></i> +63 285514405</a>
                <a href="mailto:reservationrenatosplace@gmail.com">
                    <i class="fas fa-envelope"></i> reservationrenatosplace@gmail.com
                </a>
                <a href="https://www.google.com/maps/search/?api=1&query=Noel's+Village+Cabrera+Road+Brgy+Dolores+Taytay+Rizal+Philippines" 
                target="_blank">
                    <i class="fas fa-map"></i> Noel's Village, Cabrera Road, Brgy. Dolores Taytay, Rizal, Taytay, Philippines
                </a>

            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#"> <i class="fas fa-arrow-right"></i> home</a>
                <a href="#"> <i class="fas fa-arrow-right"></i> about</a>
                <a href="#"> <i class="fas fa-arrow-right"></i> rooms</a>
                <a href="#"> <i class="fas fa-arrow-right"></i> gallery</a>
                <a href="#"> <i class="fas fa-arrow-right"></i> reservation</a>
            </div>

            <div class="box">
            <h3>location map</h3>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.467970015322!2d121.14877065747002!3d14.572389786502475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c77658906ef5%3A0x1a8766e8bc567d0d!2sRenato&#39;s%20Place%20Private%20Resort%20and%20Events!5e0!3m2!1sen!2sph!4v1724817564370!5m2!1sen!2sph"
                width="300" 
                height="200" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        </div>

        <div class="share">
            <a href="https://www.facebook.com/profile.php?id=100063738415086" class="fab fa-facebook-f" target="_blank"></a>
        </div>

        <div class="credit">&copy; copyright @ 2024 <span>renatos events place</span></div>

    </section>

    <!--end-->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="Js/script.js"></script>
    
</body>
</html>