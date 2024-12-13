<?php
// Start the session
session_start();

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");  // Redirect to login page if not logged in
//     exit();
// }

// Database connection details
include 'config.php'; // Database connection

// Fetch total users from the database
$total_users_sql = "SELECT COUNT(*) AS total_users FROM user";
$result = $conn->query($total_users_sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

// Fetch completed bookings
$completed_bookings_sql = "SELECT COUNT(*) AS completed_bookings FROM booking WHERE b_status = 'completed'";
$result = $conn->query($completed_bookings_sql);
$row = $result->fetch_assoc();
$completed_bookings = $row['completed_bookings'];

// Fetch pending bookings
$pending_bookings_sql = "SELECT COUNT(*) AS pending_bookings FROM booking WHERE b_status = 'pending'";
$result = $conn->query($pending_bookings_sql);
$row = $result->fetch_assoc();
$pending_bookings = $row['pending_bookings'];

// // Fetch total income based on completed bookings
// $total_income_sql = "SELECT SUM(amount) AS total_income FROM booking WHERE b_status = 'completed'";  // Assuming there's an 'amount' field
// $result = $conn->query($total_income_sql);
// $row = $result->fetch_assoc();
// $total_income = $row['total_income'];

// Fetch new bookings (pending bookings)
$new_booking_sql = "SELECT COUNT(*) AS new_booking FROM booking WHERE b_status = 'pending'";
$result = $conn->query($new_booking_sql);
$row = $result->fetch_assoc();
$new_booking = $row['new_booking'];

// Close the database connection
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
    <style>
        /* Pending Bookings Section */
.pending-bookings {
    margin-top: 40px;
}

.booking-item {
    background-color: #ffffff;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease-in-out;
}

.booking-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.booking-item p {
    margin: 10px 0;
    font-size: 16px;
}

.booking-item .booking-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.booking-item .booking-header p {
    font-weight: bold;
    color: #34495e;
}

.booking-item .buttons {
    display: flex;
    gap: 15px;
    justify-content: flex-start;
}

.booking-item .buttons a {
    padding: 10px 15px;
    font-size: 14px;
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}




/* Confirm and Reject Buttons Styling */
.booking-item .buttons a {
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 8px;
    text-align: center;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    width: 120px;
}

/* Confirm Button */
.booking-item .buttons .confirm-btn {
    background-color: #27ae60;  /* Green for Confirm */
    color: #fff;
    border: 2px solid #27ae60;
}

.booking-item .buttons .confirm-btn:hover {
    background-color: #2ecc71;  /* Lighter green on hover */
    box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
    transform: translateY(-2px);  /* Slight lift on hover */
}

/* Reject Button */
.booking-item .buttons .reject-btn {
    background-color: #e74c3c;  /* Red for Reject */
    color: #fff;
    border: 2px solid #e74c3c;
}

.booking-item .buttons .reject-btn:hover {
    background-color: #c0392b;  /* Darker red on hover */
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    transform: translateY(-2px);  /* Slight lift on hover */
}

/* Disabled Button State (optional) */
.booking-item .buttons a.disabled {
    background-color: #bdc3c7;
    color: #7f8c8d;
    cursor: not-allowed;
    border: 2px solid #bdc3c7;
    box-shadow: none;
}

.booking-item .buttons a.disabled:hover {
    background-color: #bdc3c7;
    transform: none;
}



/* Responsive Styling for Smaller Screens */
@media (max-width: 768px) {
    .pending-bookings {
        padding: 20px;
    }

    .booking-item {
        flex-direction: column;
    }

    .booking-item .buttons {
        flex-direction: column;
    }
}

    </style>
    <div class="sidebar">
        <div class="logo">
            <h2>Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="list.php">Users</a></li>
            <li><a href="booking.php">Bookings</a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
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
                <h3>New Bookings</h3>
                <p><?php echo $new_booking; ?></p>
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
                <p>$<?php echo number_format($total_income, 2); ?></p>
            </div>
        </div>

        <h2>Pending Bookings</h2>
        <div class="pending-bookings">
            <?php
            // Fetch all pending bookings for review
            include 'config.php';
            $sql = "SELECT * FROM booking WHERE b_status = 'pending'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="booking-item">';
                    echo '<p>User ID: ' . $row['u_id'] . '</p>';
                    echo '<p>Booking Date: ' . $row['b_date'] . '</p>';
                    echo '<p>Booking Time: ' . $row['b_time'] . '</p>';
                    echo '<a href="confirm_booking.php?id=' . $row['b_id'] . '" class="btn confirm-btn">Confirm</a>';
                    echo '<a href="reject_booking.php?id=' . $row['b_id'] . '" class="btn reject-btn">Reject</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No pending bookings at the moment.</p>';
            }
            ?>
        </div>

    </div>
</body>
</html>
