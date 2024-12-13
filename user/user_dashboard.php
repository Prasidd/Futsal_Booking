<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$user_name = $_SESSION['user_name']; // Assuming user name is stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>User Dashboard - Futsal Booking</title>
    <link rel="stylesheet" href="styles/dashboard.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
        }

        .navbar {
            background-color: #030e2e;
            color: white;
            padding: 5px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }
       
        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            margin: 15px;
        }

        .welcome {
        font-size: 24px;
        display: flex;
        justify-content: space-between; /* This ensures the button aligns to the right */
        align-items: center;
        margin-top:-80px;

        }

        .nav-links {
            display: flex;
            justify-content: space-evenly;
            margin: 20px 0;
        }

        .nav-links a {
            text-decoration: none;
            color: #030e2e;
            padding: 10px 20px;
            border: 2px solid #030e2e;
            border-radius: 5px;
            font-size: 18px;
        }

        .nav-links a:hover {
            background-color: #030e2e;
            color: white;
        }

        .logout-btn {
            background-color: white;
            color: #030e2e;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color:#030e2e;
            color:white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Futsal Booking System</h1>
        <div class="welcome">
            <p>Welcome, <?php echo htmlspecialchars($user_name); ?>!</p>
            <form action="logout.php" method="POST">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
        </div>
    </div>

    <div class="container">
        <div class="nav-links">
            <a href="home.php">Home</a>
            <!-- <a href="about_us.php">About Us</a> -->
            <a href="check_booking.php">Booking</a>
            <a href="history.php">Booking History</a>
            <a href="profile.php">Profile</a>
            
        </div>

      
    </div>
</body>
</html>
