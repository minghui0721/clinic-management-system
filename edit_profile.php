<?php
include 'admin/db_connect.php';
// I created another variable to store the session value
// Before Editing
$id = $_SESSION['login_id'];

$query = "SELECT * FROM users WHERE id = $id";
$results = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($results);

$name = $row['name'] ;
$address = $row['address'] ;
$contact = $row['contact'] ;
$username = $row['username'] ;

// After Editing and Click Submit - data Will be inserted into database
if(isset($_POST['btnSave'])){
    $Nname = $_POST['name'];
    $Naddress = $_POST['address'];
    $Ncontact = $_POST['contact'];
    $Nusername = $_POST['username'];

    // Query
    $query = "UPDATE `users` SET `name`='$Nname', `address`='$Naddress', `contact`='$Ncontact', `username`='$Nusername' WHERE `id`= $id";

    // Run
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Profile Info successfully edited!'); setTimeout(function() {window.location.href='index.php?page=home';}, 0);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css?v=<?php echo time(); ?>.css">
</head>
<body>
    
        <!-- THE INFO -->

        <form method="post" id="confirm_form">
            <div id="info">

                <div id="appointment">

                    <h2>User Profile</h2>
                    <h3>Patient ID</h3>
                    <input type="text" id="id" name="id" value="<?php echo $id ?>" disabled>
                    
                    <h3>Name</h3>
                    <input type="text" id="name" name="name" value="<?php echo $name?>" require>

                    <h3>Address</h3>
                    <input type="text" id="name" name="address" value="<?php echo $address?>" require>

                    <h3>Contact</h3>
                    <input type="text" id="name" name="contact" value="<?php echo $contact?>" require>

                    <h3>Email</h3>
                    <input type="email" id="name" name="username" value="<?php echo $username?>" require>

                </div>

            </div>

            <div id="info2">            
                    <!-- Check box -->
                    <div id="rules">
                        <input type="checkbox" name="confirm" id="confirm" required>
                        I' ve read and confirmed the informationas
                    </div>
         
                    <!-- Submit Button -->
                    <input type="submit" name="btnSave" value="Save your Info">
            </div>
        </form>

    </div>

</body>
</html>