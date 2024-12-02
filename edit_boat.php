<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "projectp5");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $available_from = $_POST['available_from'];
    $available_to = $_POST['available_to'];
    $description = $_POST['description'];

    $sql = "UPDATE boats SET name = '$name', type = '$type', location = '$location', price = '$price', 
            available_from = '$available_from', available_to = '$available_to', description = '$description' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message in the query string
        header("Location: admin.php?message=success");
        exit();
    } else {
        // Redirect with error message
        header("Location: admin.php?message=error");
        exit();
    }
}

$boat_id = $_GET['id'];
$sql = "SELECT * FROM boats WHERE id = $boat_id";
$result = $conn->query($sql);
$boat = $result->fetch_assoc();
?>

<?php include('header.php'); ?>
<h2>Boot Bewerken</h2>
<form action="edit_boat.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $boat['id']; ?>">
    <label for="name">Naam</label>
    <input type="text" name="name" id="name" value="<?php echo $boat['name']; ?>" required>

    <label for="type">Type</label>
    <select name="type" id="type" required>
        <option value="sail" <?php echo $boat['type'] == 'sail' ? 'selected' : ''; ?>>Zeilboot</option>
        <option value="motor" <?php echo $boat['type'] == 'motor' ? 'selected' : ''; ?>>Motorboot</option>
    </select>

    <label for="location">Locatie</label>
    <input type="text" name="location" id="location" value="<?php echo $boat['location']; ?>" required>

    <label for="price">Prijs</label>
    <input type="text" name="price" id="price" value="<?php echo $boat['price']; ?>" required>

    <label for="available_from">Beschikbaar vanaf</label>
    <input type="date" name="available_from" id="available_from" value="<?php echo $boat['available_from']; ?>" required>

    <label for="available_to">Beschikbaar tot</label>
    <input type="date" name="available_to" id="available_to" value="<?php echo $boat['available_to']; ?>" required>

    <label for="description">Beschrijving</label>
    <textarea name="description" id="description" required><?php echo $boat['description']; ?></textarea>

    <input type="submit" value="Bijwerken">
</form>

<?php include('footer.php'); ?>
