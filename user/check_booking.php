<?php

include('user_dashboard.php');
include ('../config.php');

$message = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

if (isset($_POST['submit'])) {
   
    if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['payment_method'])) {
        $user_id = $_SESSION['user_id']; 
        $booking_date = $_POST['date'];
        $booking_time = $_POST['time'];
        $payment_method = $_POST['payment_method'];
        $booking_amount = 2500; 
        
            $query = mysqli_query($conn, "SELECT * FROM booking WHERE b_date = '$booking_date' AND b_time = '$booking_time' AND b_status != 'completed'");

            if (mysqli_num_rows($query) > 0) {
                $message = "Sorry, this time slot is already booked.";
            } else {
                $insert_booking_query = "INSERT INTO booking (u_id, b_date, b_time, b_status, p_method, b_amount) 
                                         VALUES ('$user_id', '$booking_date', '$booking_time', 'pending', '$payment_method', '$booking_amount')";
                if (mysqli_query($conn, $insert_booking_query)) {
                    $booking_id = mysqli_insert_id($conn);
                    $insert_payment_query = "INSERT INTO payment (u_id, b_id, p_status) 
                                              VALUES ('$user_id', '$booking_id', 'pending')";
                    if (mysqli_query($conn, $insert_payment_query)) {
                        $message = "Your booking is successfully created, and payment is recorded. We will confirm it soon!";
                    } else {
                        $message = "Booking is successful, but there was an error while recording the payment.";
                    }
                } else {
                    $message = "There was an error while booking your slot. Please try again.";
                }
            }
        }
    } else {
        $message = "Please select both a date, time, and a payment method.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>User Booking</title>
  
    <style>


        .form-container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: white;
        }

        label {
            font-size: 18px;
            margin: 10px 0;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #030e2e;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #222;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            text-align: center;
            color: #030e2e;
        }

        .amount-container {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #030e2e;
        }

        footer {
            background-color: #030e2e;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            
        }

        
    </style>
</head>
<body>

    
    <div class="form-container">
        <h1>Book Your Slot</h1>

        <form method="POST" action=""> 

            <label for="date">Select a Date:</label>
            <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required />

            <label for="time">Select a Time:</label>
            <select id="time" name="time" required>
                <option value="06:00AM - 07:00AM">06:00 AM - 07:00 AM</option>
                <option value="07:00AM - 08:00AM">07:00 AM - 08:00 AM</option>
                <option value="08:00AM - 09:00AM">08:00 AM - 09:00 AM</option>
                <option value="09:00AM - 10:00AM">09:00 AM - 10:00 AM</option>
                <option value="10:00AM - 11:00AM">10:00 AM - 11:00 AM</option>
                <option value="11:00AM - 12:00PM">11:00 AM - 12:00 PM</option>
                <option value="12:00PM - 01:00PM">12:00 PM - 01:00 PM</option>
                <option value="01:00PM - 02:00PM">01:00 PM - 02:00 PM</option>
                <option value="02:00PM - 03:00PM">02:00 PM - 03:00 PM</option>
                <option value="03:00PM - 04:00PM">03:00 PM - 04:00 PM</option>
                <option value="04:00PM - 05:00PM">04:00 PM - 05:00 PM</option>
                <option value="05:00PM - 06:00PM">05:00 PM - 06:00 PM</option>
                <option value="06:00PM - 07:00PM">06:00 PM - 07:00 PM</option>
                <option value="07:00PM - 08:00PM">07:00 PM - 08:00 PM</option>
                <option value="08:00PM - 09:00PM">08:00 PM - 09:00 PM</option>
            </select>

            <div class="amount-container">
                Fixed Booking Amount: <strong>2500</strong> <br><br>
            </div>

            <label for="payment_method">Choose a Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="Cash On Arena">Cash on Arena</option>
                <option value="Online Payment">Online Payment</option>
            </select>

            <button type="submit" name="submit">Book Now</button>
        </form>

        <?php if ($message != ''): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2024 Futsal Booking. All Rights Reserved.</p>
    </footer>
</body>
</html>
