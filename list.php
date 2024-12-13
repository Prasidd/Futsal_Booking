<?php
session_start();
include 'config.php';

$query = "SELECT * FROM `user`";
$result = mysqli_query($conn, $query);

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");  
    exit();
}

if (!$result) {
    die("Query failed: " . mysqli_error($conn)); 
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];  
    $delete_query = "DELETE FROM `user` WHERE `u_id` = '$delete_id'";
    
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['delete'] = "User Deleted Sucessfully";
        header('location: list.php');
        exit;
    } else {
        echo "<script>alert('Error deleting user');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Data</title>
    <link rel="stylesheet" href="styles/admin.css"> 
<body>
<div class="sidebar">
        <div class="logo">
            <h2>Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="list.php">Users</a></li>
            <li><a href="booking.php">Bookings</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
    <section class="container">
        <header>User Data Table</header>
        <?php
        if(isset($_SESSION['delete'])){
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
        }?>
       
        <table border="1">
            <thead>
                <tr>
                <th>S.N.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $count = mysqli_num_rows($result);

                $sn = 1; 
                if ($count > 0) { 
                    while ($row = mysqli_fetch_assoc($result)) {  
                        $id = $row['u_id'];
                        $name = $row['u_name'];  
                        $email = $row['u_email'];  
                        $address = $row['u_address']; 
                        $contact = $row['u_contact']; 
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>  
                            <td><?php echo $name; ?></td>  
                            <td><?php echo $email; ?></td>  
                            <td><?php echo $address; ?></td> 
                            <td><?php echo $contact; ?></td> 
                            <td><a href="?delete_id=<?php echo $id; ?>"><button>Delete</button></a></td> 
                        </tr>
                        <?php
                    }
                } else {
                   
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
        </tbody>
        </table>
    </section>
</body>
</html>

<?php

mysqli_close($conn);
?>
