<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "projectp5");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM boats";
$result = $conn->query($sql);

?>

<?php include('header.php'); ?>

<h2>Beheer Boten</h2>

<a href="add_boat.php">Nieuwe Boot Toevoegen</a>

<h3>Beschikbare Boten</h3>
<table>
    <tr>
        <th>Naam</th>
        <th>Type</th>
        <th>Locatie</th>
        <th>Prijs</th>
        <th>Beschikbaarheid</th>
        <th>Acties</th>
    </tr>

<?php
while ($boat = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $boat["name"] . "</td>";
    echo "<td>" . $boat["type"] . "</td>";
    echo "<td>" . $boat["location"] . "</td>";
    echo "<td>" . $boat["price"] . "</td>";
    echo "<td>" . $boat["available_from"] . " - " . $boat["available_to"] . "</td>";
    echo "<td>
            <a href='edit_boat.php?id=" . $boat["id"] . "'>Bewerken</a> | 
            <a href='delete_boat.php?id=" . $boat["id"] . "'>Verwijderen</a>
          </td>";
    echo "</tr>";
}
?>

</table>

<?php
$conn->close();
?>

<?php include('footer.php'); ?>