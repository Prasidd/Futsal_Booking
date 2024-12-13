<?php
include('user_dashboard.php');
$conn = mysqli_connect('localhost', 'root', '', 'futsal_management') or die('Connection failed');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; 

$query = "SELECT * FROM booking WHERE u_id = '$user_id' ORDER BY b_date DESC";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>User Booking History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

       

        .welcome {
            margin-right: 20px;
        }


        .content {
            margin: 20px;
        }

        .booking-history {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .booking-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .booking-item h3 {
            margin: 0;
            font-size: 18px;
            color: #030e2e;
        }

        .booking-details {
            font-size: 16px;
            color: #555;
        }

        .message {
            background-color: #f9f9f9;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            border: 1px solid #ddd;
            color: #030e2e;
        }
    </style>
</head>
<body>

    

    <div class="content">
        <h2>Your Booking History</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <!-- Display booking history using divs -->
            <div class="booking-history">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="booking-item">
                        <h3>Booking ID: <?php echo htmlspecialchars($row['b_id']); ?></h3>
                        <div class="booking-details">
                            <p><strong>Booking Date:</strong> <?php echo $row['b_date']; ?></p>
                            <p><strong>Booking Time:</strong> <?php echo $row['b_time']; ?></p>
                            <p><strong>Booking Amount:</strong> <?php echo $row['b_amount']; ?></p>
                            <p><strong>Payment Method:</strong> <?php echo $row['p_method']; ?></p>
                            <p><strong>Status:</strong> <?php echo $row['b_status']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="message">You have no past bookings.</div>
        <?php endif; ?>
    </div>

</body>
</html>