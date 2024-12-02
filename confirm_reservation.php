<?php include('header.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "projectp5");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $boat_id = $_POST['boat_id'];
    $date = $_POST['date'];
    $extras = isset($_POST['extras']) ? $_POST['extras'] : [];

    $sql = "SELECT price FROM boats WHERE id = $boat_id";
    $result = $conn->query($sql);
    $boat = $result->fetch_assoc();
    $total_price = $boat['price'];

    foreach ($extras as $extra_id) {
        $sql = "SELECT price FROM extras WHERE id = $extra_id";
        $result = $conn->query($sql);
        $extra = $result->fetch_assoc();
        $total_price += $extra['price'];
    }

    $sql = "INSERT INTO reservations (customer_name, email, boat_id, reservation_date, total_price) 
            VALUES ('$name', '$email', '$boat_id', '$date', '$total_price')";
    
    if ($conn->query($sql) === TRUE) {
        $reservation_id = $conn->insert_id;

        foreach ($extras as $extra_id) {
            $sql = "INSERT INTO reservation_extras (reservation_id, extra_id) 
                    VALUES ($reservation_id, $extra_id)";
            $conn->query($sql);
        }

        echo "Reservering bevestigd! Totaal: €" . $total_price;
    } else {
        echo "Fout bij reserveren: " . $conn->error;
    }

    $conn->close();
}
?>

<?php include('footer.php'); ?>
