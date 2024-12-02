<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "projectp5");

$boat_id = $_GET['id'];

$sql = "DELETE FROM boats WHERE id = $boat_id";

if ($conn->query($sql) === TRUE) {
    echo "Boot succesvol verwijderd!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
header("Location: admin.php");
exit();
?>