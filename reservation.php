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
        $dateOfStay = $_POST['PreferredDateofStay'];
        $poolOption = $_POST['PoolOptions'];
        

        $conn = new mysqli('localhost','root','','renatosplace_db');

        $sql = "INSERT INTO renatos_db(FullName,Email,ContactNumber,FullAddress,NumberofGuests,PreferredDateofStay,PoolOptions,Date) 
        VALUES('$fname', '$email', '$phone', '$address', '$guest', '$dateOfStay', '$poolOption','$date')";

        if($conn ->query($sql)){
            $message = "<div class='alert alert-success'>Successfull</div>";
        }else{
            $message = "<div class='alert alert-danger'>Please try again </div>";
        }

}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renatos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="">
</head>
<body>
    
    
    <section>
    <div class="container">
        <h1 class="text-center alert alert-danger" style="background:#3498db;border:none;color:#fff">Event and Other Reservation</h1>
        <div class="row">
            <div class="col-md-12">
                <?php echo isset($message)?$message:'';?>
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" class="form-control" name="FullName" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="">Contact-Number</label>
                        <input type="text" class="form-control" name="ContactNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="">Full-Address</label>
                        <input type="text" class="form-control" name="FullAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="">Number-of-Guests</label>
                        <input type="text" class="form-control" name="NumberofGuests" required>
                    </div>
                    <div class="form-group">
                        <label for="">Preferred-Date-of-Stay</label>
                        <input type="date" class="form-control" name="PreferredDateofStay" required>
                    </div>
                    <div class="form-group">
                        <label for="">Pool-Options</label>
                        <select name="PoolOptions" class="form-control"  required>
                        <option value="1">Daytime</option>
                        <option value="2">Overnight</option>
                        <option value="3">Staycation</option>
                        <option value="4">Events + Pool</option>
                        <option value="5">Events Place</option>
                    </select>

                    <br>

                   

                    <br>
                    <br>
                    <br>


                    <button type="submit" name="submit" class="btn btn-primary"> Submit </button>
                    <a href="home.php" class="btn btn-success">Back</a>


                </form>
            </div>
        </div>
    </div>
    </section>

    


    
</body>
</html>