<?php
// Start the session
session_start();

// Destroy all session variables
session_unset(); 

// Destroy the session itself
session_destroy();

// Redirect the user to the login page or homepage
header("Location: ../login.php"); // Or any other page like login.php
exit();
?>
