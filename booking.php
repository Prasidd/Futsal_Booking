<?php
session_start();
include 'config.php'; 

$message = '';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); 
    exit();
}

if (isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE booking SET b_status = '$new_status' WHERE b_id = '$booking_id'";
    if (mysqli_query($conn, $update_query)) {
        $message = "Booking status updated successfully!";
    } else {
        $message = "Error updating booking status.";
    }
}

$bookings_query = mysqli_query($conn, "
    SELECT b.b_id, b.u_id, b.b_status, b.b_date, b.b_time, u.u_name, u.u_contact
    FROM booking b
    JOIN user u ON b.u_id = u.u_id
") or die("Query failed");

$bookings_data = mysqli_fetch_all($bookings_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Booking Management</title>
    <link rel="stylesheet" href="styles/booking.css" />
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
        }

        .sidebar {
            width: 250px;
            background-color: #030e2e;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            padding: 20px;
        }

        .sidebar .logo h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #444;
        }

        .main-content {
            margin-left: 270px;
            padding: 30px;
            background-color: #fff;
            min-height: 100vh;
            width: 1200px;
        }

        h1 {

            font-size: 36px;
            color: #030e2e;
          
            text-align: center;
        }

        .message-popup {
            background-color: #030e2e;
            border: 1px solid #4caf50;
            padding: 20px;
            border-radius: 5px;
            color:white;
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .message-popup button {
            background-color: white;
            color: #030e2e;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .message-popup button:hover {
            background-color: #030e2e;
            color:white;
        }

        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            width: 100%;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1400px;
        }

        .stat-card table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .stat-card table th, .stat-card table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .stat-card table th {
            background-color: #030e2e;
            color: white;
        }

        .stat-card table td {
            background-color: #f9f9f9;
        }

        .stat-card table tr:hover {
            background-color: #f1f1f1;
        }

        .stat-card select, .stat-card button {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .stat-card button {
            background-color: #030e2e;
            color: white;
            cursor: pointer;
            border: none;
            margin-left: 10px;
        }

        .stat-card button:hover {
            background-color: #222;
        }

    </style>
    </style>
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <h2>Admin Dashboard</h2>
    </div>
    <ul>
        <li><a href="admin.php">Dashboard</a></li>
        <li><a href="list.php">Users</a></li>
        <li><a href="booking.php">Bookings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Booking List</h1>

    <?php if ($message != ''): ?>
    <div id="popup-message" class="message-popup">
        <p><?php echo $message; ?></p>
        <button onclick="closePopup()">Exit</button>
    </div>
    <?php endif; ?>

    <div class="stats-container">
        <div class="stat-card">
            <table>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>User Name</th> 
                    <th>User Contact</th> 
                    <th>Status</th>
                    <th>Booking Date</th>
                    <th>Booked for</th>
                    <th>Change Status</th>
                </tr>
                <?php foreach ($bookings_data as $booking): ?>
                <tr>
                    <td><?php echo $booking['b_id']; ?></td>
                    <td><?php echo $booking['u_id']; ?></td>
                    <td><?php echo $booking['u_name']; ?></td> 
                    <td><?php echo $booking['u_contact']; ?></td> 
                    <td><?php echo $booking['b_status']; ?></td>
                    <td><?php echo $booking['b_date']; ?></td>
                    <td><?php echo $booking['b_time']; ?></td>
                    <td>
                        <form method="POST" action="" style="display: inline;">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['b_id']; ?>" />
                            <select name="status" required>
                                <option value="pending" <?php echo ($booking['b_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo ($booking['b_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById("popup-message").style.display = "none";
    }
</script>
</body>
</html>
