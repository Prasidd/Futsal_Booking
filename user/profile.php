<?php

include('user_dashboard.php');
$conn = mysqli_connect('localhost', 'root', '', 'futsal_management') or die('Connection failed');

if (!isset($_SESSION['user_id'])) {

    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; 


$query = "SELECT * FROM user WHERE u_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        header {
            background-color: #030e2e;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            font-size: 18px;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .welcome {
            margin-right: 20px;
        }

       

        .content {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #030e2e;
            margin-bottom: 20px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-info div {
            font-size: 16px;
            color: #555;
        }

        .profile-info strong {
            color: #030e2e;
        }

        .profile-info .edit-btn {
            background-color: #030e2e;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .profile-info .edit-btn:hover {
            background-color: #222;
        }

    </style>
</head>
<body>

    <div class="content">
        <h2>Your Profile</h2>

        <div class="profile-info">
            <div>
                <strong>Name:</strong> <?php echo $user['u_name']; ?>
            </div>
            <div>
                <strong>Email:</strong> <?php echo $user['u_email']; ?>
            </div>
            <div>
                <strong>Phone Number:</strong> <?php echo $user['u_contact']; ?>
            </div>
            <div>
                <strong>Address:</strong> <?php echo $user['u_address']; ?>
            </div>
        </div>

        
    </div>

</body>
</html>
