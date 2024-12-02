<?php
session_start(); // Start session to destroy it

// Destroy the session to log out
session_destroy();

// Redirect to the home page after logging out
header("Location: index.php");
exit();
?>
