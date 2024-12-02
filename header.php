<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jachtverhuur Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-left">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Reseveringen</a>
            <?php 
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {} else {echo '<a href="admin.php">Admin</a>';}
            ?>
        </div>
        <div class="header-right">
            <?php 
            if(isset($_SESSION['user_id'])) {
                echo '<a href="logout.php">Log Out</a>';
            } else {
                echo '<a href="login.php">Log In</a>';
            }
            ?>
        </div>
    </header>
</body>
</html>