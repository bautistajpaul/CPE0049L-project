<?php
    require('includes/essentials.php');
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Css/dashbord.css">
</head>
<body>
     <!-- Header -->
     <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center sticky-top">
        <div class="logo">
            <img src="">
            <h3 class="mb-0 h-font">Renatos Event's Place</h3>
            <a href="logout.php" class="btn btn-light btn-sm logout-btn">LOG OUT</a>
        </div>
    </div>
    <!-- End Header -->

    <!-- Sidebar Menu -->
    <div class="sidebar" id="dashboard-menu">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid flex-lg-column align-item-stretch">
                <h4 class="sidebar-title">ADMIN PANEL</h4>
                <div class="collapse navbar-collapse flex-column align-items-stretch" id="adminDropdown">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- End Sidebar Menu -->

    <!-- Main Content -->
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Dashbord</h3>

                <!-- Body of Dashbord -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-10">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium veniam, eos possimus quod ipsa, sed nobis modi excepturi dicta suscipit iste eum nostrum doloremque obcaecati id quos quo tenetur officia?
                        </div>
                    </div>
                </div>

            </div>
        </div>
     </div>
    <!-- End Main Content -->
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
