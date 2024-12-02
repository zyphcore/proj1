<?php include('header.php'); ?>
<h2>Zoek Jachten</h2>

<form action="search.php" method="GET">
    <label for="type">Type</label>
    <select name="type" id="type">
        <option value="sail">Zeilboot</option>
        <option value="motor">Motorboot</option>
    </select>

    <label for="location">Locatie</label>
    <input type="text" name="location" id="location" required>

    <label for="date">Vertrekdatum</label>
    <input type="date" name="date" id="date" required>

    <input type="submit" value="Zoeken">
</form>

<?php
$conn = new mysqli("localhost", "root", "", "projectp5");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['type']) && isset($_GET['location']) && isset($_GET['date'])) {
    $type = $_GET['type'];
    $location = $_GET['location'];
    $date = $_GET['date'];

    $sql = "SELECT * FROM boats WHERE type = '$type' AND location LIKE '%$location%' AND available_from <= '$date' AND available_to >= '$date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Jacht: " . $row["name"] . " - " . $row["price"] . " per dag <br>";
            echo "<a href='reserve.php?boat_id=" . $row["id"] . "'>Reserveer</a><br><br>";
        }
    } else {
        echo "Geen jachten gevonden.";
    }
}

$conn->close();
?>
<?php include('footer.php'); ?>