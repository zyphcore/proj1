<?php include('header.php'); ?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "projectp5");

$email = $_SESSION['email'];
$sql = "SELECT * FROM reservations WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Reservering: " . $row["boat_id"] . " - Datum: " . $row["reservation_date"] . " - Totaal: €" . $row["total_price"] . "<br>";
    }
} else {
    echo "Geen reserveringen gevonden.";
}

$conn->close();
?>
<?php include('footer.php'); ?>