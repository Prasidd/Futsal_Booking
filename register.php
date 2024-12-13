<?php
include 'config.php';
$message = ''; 
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $number = $_POST['contact'];
    $password = $_POST['password'];
    $cpass = $_POST['cpassword'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_c_password = password_hash($cpass, PASSWORD_DEFAULT);

    $select_users = mysqli_query($conn, "SELECT * FROM `user` WHERE u_email = '$email' or u_contact='$number'") or die("query failed");

    if(mysqli_num_rows($select_users)>0){
        $message = 'User already exists!';
    } else {
        if($password != $cpass){
            $message = 'Confirm password does not match.';
        } else {
            mysqli_query($conn,"INSERT INTO `user` (u_name,u_address,u_email,u_password,u_contact) VALUES ('$name','$address','$email','$hashed_password','$number')") or die('query failed');
            $message = 'Registered successfully!';
            header('Location: login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="styles/register.css" />
    <script>
        function closePopup() {
            document.getElementById("popup-message").style.display = "none";
        }
    </script>
</head>
<body>
    <section class="container">
        <header>Registration Form</header>

    
        <?php if ($message != ''): ?>
        <div id="popup-message" class="message-popup">
            <p><?php echo $message; ?></p>
            <button onclick="closePopup()" class="close-btn">Exit</button>
        </div>
        <?php endif; ?>

        <form action="#" class="form" method="POST">
            <div class="input-box">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter full name" required />
            </div>
            <div class="input-box">
                <label>Address</label>
                <input type="text" name="address" placeholder="Enter address" required />
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Phone Number</label>
                    <input type="tel" name="contact" placeholder="Enter phone number" required pattern="\d{10}" maxlength="10" minlength="10"/>
                </div>
            </div>
            <div class="input-box">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter email address" required />
            </div>

            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required />
            </div>
            <div class="input-box">
                <label>Confirm Password</label>
                <input type="password" name="cpassword" placeholder="Confirm password" required />
            </div>

            <input type="submit" name="submit" value="Submit" class="submit">
        </form>
    </section>
</body>
</html>

