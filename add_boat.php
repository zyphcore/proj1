<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure the user is logged in as admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "projectp5");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission to add a boat
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        // Validate and sanitize form data
        $name = $conn->real_escape_string($_POST['name']);
        $type = $conn->real_escape_string($_POST['type']);
        $location = $conn->real_escape_string($_POST['location']);
        $price = $conn->real_escape_string($_POST['price']);
        $available_from = $conn->real_escape_string($_POST['available_from']);
        $available_to = $conn->real_escape_string($_POST['available_to']);
        $description = $conn->real_escape_string($_POST['description']);

        // Prepare the SQL query
        $sql = "INSERT INTO boats (name, type, location, price, available_from, available_to, description) 
                VALUES ('$name', '$type', '$location', '$price', '$available_from', '$available_to', '$description')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            $success_message = "Boot succesvol toegevoegd!";
        } else {
            $error_message = "Fout bij toevoegen van boot: " . $conn->error;
        }
    }
}

?>

<?php include('header.php'); ?>

<h2>Nieuwe Boot Toevoegen</h2>

<?php
// Display success or error message
if (isset($success_message)) {
    echo "<p style='color: green;'>$success_message</p>";
}
if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<form action="add_boat.php" method="POST">
    <label for="name">Naam</label>
    <input type="text" name="name" id="name" required>

    <label for="type">Type</label>
    <select name="type" id="type" required>
        <option value="sail">Zeilboot</option>
        <option value="motor">Motorboot</option>
    </select>

    <label for="location">Locatie</label>
    <input type="text" name="location" id="location" required>

    <label for="price">Prijs</label>
    <input type="text" name="price" id="price" required>

    <label for="available_from">Beschikbaar vanaf</label>
    <input type="date" name="available_from" id="available_from" required>

    <label for="available_to">Beschikbaar tot</label>
    <input type="date" name="available_to" id="available_to" required>

    <label for="description">Beschrijving</label>
    <textarea name="description" id="description" required></textarea>

    <input type="hidden" name="action" value="add">
    <input type="submit" value="Toevoegen">
</form>

<?php
$conn->close();
?>

<?php include('footer.php'); ?>