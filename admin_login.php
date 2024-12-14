<?php
session_start();
include 'config.php'; 

$message = '';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE a_email = '$email' AND a_password = '$password'") or die("Query failed");

    if (mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);
        $_SESSION['admin_id'] = $admin['a_id'];
        $_SESSION['admin_email'] = $admin['a_email'];
        header('Location: admin.php');
        exit;
    } else {
        $message = 'Admin email or password is incorrect!';
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
</head>
<body>
    <section class="container">
        <header>Admin Login Form</header>
        <?php if ($message != ''): ?>
        <div id="popup-message" class="message-popup">
            <p><?php echo $message; ?></p>
            <button onclick="document.getElementById('popup-message').style.display='none'" class="close-btn">Exit</button>
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
        
    </section>
</body>
</html>
