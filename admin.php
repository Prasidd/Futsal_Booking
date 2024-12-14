<?php

session_start();


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); 
    exit;
}

include 'config.php'; 


$total_users_sql = "SELECT COUNT(*) AS total_users FROM user";
$result = $conn->query($total_users_sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

$completed_bookings_sql = "SELECT COUNT(*) AS completed_bookings FROM booking WHERE b_status = 'completed'";
$result = $conn->query($completed_bookings_sql);
$row = $result->fetch_assoc();
$completed_bookings = $row['completed_bookings'];

$pending_bookings_sql = "SELECT COUNT(*) AS pending_bookings FROM booking WHERE b_status = 'pending'";
$result = $conn->query($pending_bookings_sql);
$row = $result->fetch_assoc();
$pending_bookings = $row['pending_bookings'];

$total_income_sql = "8000";

$total_income = $total_income_sql;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles/dashboard.css" />
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="list.php">Users</a></li>
            <li><a href="booking.php">Bookings</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Welcome, Admin</h1>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
           
            <div class="stat-card">
                <h3>Completed Bookings</h3>
                <p><?php echo $completed_bookings; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending Bookings</h3>
                <p><?php echo $pending_bookings; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Income</h3>
                <p><?php echo number_format($total_income, 2); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
