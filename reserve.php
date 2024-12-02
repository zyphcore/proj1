<?php include('header.php'); ?>

<?php
if (isset($_GET['boat_id'])) {
    $boat_id = $_GET['boat_id'];

    $conn = new mysqli("localhost", "root", "", "projectp5");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM boats WHERE id = $boat_id";
    $result = $conn->query($sql);
    $boat = $result->fetch_assoc();

    echo "<h2>Reserveer: " . $boat['name'] . "</h2>";
    echo "Prijs per dag: €" . $boat['price'] . "<br>";

    $sql = "SELECT * FROM extras";
    $extras = $conn->query($sql);

    echo "<form action='confirm_reservation.php' method='POST'>";
    echo "<label for='name'>Naam</label><input type='text' name='name' id='name' required>";
    echo "<label for='email'>E-mail</label><input type='email' name='email' id='email' required>";
    echo "<label for='date'>Vertrekdatum</label><input type='date' name='date' id='date' required>";

    echo "<h3>Opties:</h3>";
    while ($extra = $extras->fetch_assoc()) {
        echo "<input type='checkbox' name='extras[]' value='" . $extra["id"] . "'> " . $extra["name"] . " - €" . $extra["price"] . "<br>";
    }

    echo "<input type='hidden' name='boat_id' value='" . $boat_id . "'>";
    echo "<input type='submit' value='Bevestigen'>";
    echo "</form>";

    $conn->close();
} else {
    echo "Geen boot geselecteerd.";
}
?>

<?php include('footer.php'); ?>