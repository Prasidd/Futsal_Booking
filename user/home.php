
<?php

include('user_dashboard.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); 
    exit();
}

$user_name = $_SESSION['user_name']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Futsal Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
       
        header {
            background: #030e2e;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        header p {
            font-size: 18px;
            font-weight: 300;
        }

  
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 50px 10%;
            background-color: white;
            color: #030e2e;
            text-align: center;
        }

        .hero img {
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .hero .text {
            flex: 1;
            padding: 20px;
        }

        .hero h2 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .cta-btn {
            padding: 15px 30px;
            background-color: #030e2e;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .cta-btn:hover {
            background-color: #444;
        }


        .about {
            padding: 50px 10%;
            background-color: #f0f8ff;
            text-align: center;
        }

        .about h2 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #030e2e;
        }

        .about p {
            font-size: 20px;
            margin-bottom: 30px;
            line-height: 1.8;
            color: #555;
        }

        footer {
            background-color: #030e2e;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            bottom:0px;
        }
     
     
    </style>
</head>
<body>
    <section class="hero">
        <div class="text">
            <h2>Book Your Futsal Court Now!</h2>
            <p> Tired of waiting several minutes in call to just book a futsal
          ground?Here's a website to help book you futsal ground faster and
          easier than ever with real time slot availability.</p>
            <a href="check_booking.php" class="cta-btn">Book Now</a>
        </div>
        <img src="../images/ground.jpg" width ="600px" height ="400px" alt="Futsal Court Image">
    </section>
    <footer>
        <p>&copy; 2024 Futsal Booking. All Rights Reserved.</p>
    </footer>
 
</body>
</html>

