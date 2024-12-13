<?php
session_start();
include 'config.php'; // Make sure this file contains your database connection

// Initialize message variable
$message = '';

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists
    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE u_email = '$email'") or die("Query failed");
    $user = mysqli_fetch_assoc($query);

    if($user) {
        // Verify password
        if(password_verify($password, $user['u_password'])) {

            // Password is correct, start the session
            $_SESSION['user_id'] = $user['u_id'];
            $_SESSION['user_name'] = $user['u_name'];
            $_SESSION['user_email'] = $user['u_email'];
            

            header('Location: user/home.php'); 
            exit;
        } else {
            $message = 'Incorrect password!';
        }
    } else {
        $message = 'User does not exist!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="styles/login.css" />
    <script>
        function closePopup() {
            document.getElementById("popup-message").style.display = "none";
        }
    </script>
</head>
<body>
    <section class="container">
        <header>Login Form</header>

        <!-- Popup message box -->
        <?php if ($message != ''): ?>
        <div id="popup-message" class="message-popup">
            <p><?php echo $message; ?></p>
            <button onclick="closePopup()" class="close-btn">Exit</button>
        </div>
        <?php endif; ?>

        <form action="#" class="form" method="POST">
            <div class="input-box">
                <label>Email Address</label>
                <input type="text" name="email" placeholder="Enter email address" required />
            </div>
            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required />
            </div>
            <input type="submit" name="submit" value="Login" class="submit">
        </form>
        <footer>
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
        </footer>
    </section>
</body>
</html>
