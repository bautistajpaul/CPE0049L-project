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
<body class="bg-white">
    
      <!-- Header -->
     <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center sticky-top">
        <h3 class="mb-0 h-font">Renatos Event's Place</h3>
        <a href="logout.php" class="btn btn-light btn-sm logout-btn">LOG OUT</a>
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
                            <a class="nav-link" href="adminDashbord.php">Dashboard</a>
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


     <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SETTINGS</h3>

                <!-- General settings section -->

                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">General Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                         <i class="bi bi-pencil-square"></i>Edit    
                        </button>
                    </div>
                   <h6 class="card-subtitle mb-1 fw-bold">Site title 111</h6>
                   <p class="card-text" id="site_title"></p>
                   <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                   <p class="card-text" id="site_about"></p>
              </div>
             </div>

             <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
             <div class="modal-dialog">
                <form>
                <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">General Settings</h5>
                </div>
                  <div class="modal-body">
                  <div class="mb-3">
                <label class="form-label">Site Title</label>
                <input type="text" name="site_title" class="form-control shadow-none">
                </div>
                <div class="mb-3">
                <label class="form-labe">Message</label>
                <textarea name="site_about" class="form-control shadow-none" rows="6"></textarea>
                 </div>
                </div>
                 <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dark shadow-none">Submit</button>
                </div>
              </div>
            </form>
            </div>
           </div>

            </div>
        </div>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     
     <script>
        let general_data;

        function get_general()
        {
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content_Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                general_data = JSON.parse(this.responseText);
                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;
            }

            xhr.send('get_general');
        }

        window.onload = function(){
            get_general();
        }

     </script>

</body>
</html>