<?php
include('header.php');
session_start();

$conn = new mysqli("localhost", "root", "", "projectp5");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$location_filter = "";
$boats_per_page = 30; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $boats_per_page; 

if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location_filter = $_GET['location'];
}

$location_query = "SELECT DISTINCT location FROM boats";
$location_result = $conn->query($location_query);

$boat_query = "SELECT * FROM boats";
if ($location_filter) {
    $boat_query .= " WHERE location = '" . $conn->real_escape_string($location_filter) . "'";
}
$boat_query .= " LIMIT $boats_per_page OFFSET $offset"; 
$boat_result = $conn->query($boat_query);

$total_boats_query = "SELECT COUNT(*) AS total FROM boats";
if ($location_filter) {
    $total_boats_query .= " WHERE location = '" . $conn->real_escape_string($location_filter) . "'";
}
$total_boats_result = $conn->query($total_boats_query);
$total_boats = $total_boats_result->fetch_assoc()['total'];
$total_pages = ceil($total_boats / $boats_per_page); 

?>

<h1>Welkom bij het Jachtverhuur Platform</h1>
<p>Zoek en reserveer jachten voor je vakantie!</p>

<form action="index.php" method="GET">
    <label for="location">Locatie:</label>
    <select name="location" id="location" onchange="this.form.submit()">
        <option value="">Alle locaties</option>
        <?php
        while ($location = $location_result->fetch_assoc()) {
            $selected = ($location['location'] === $location_filter) ? "selected" : "";
            echo "<option value='" . $location['location'] . "' $selected>" . $location['location'] . "</option>";
        }
        ?>
    </select>
</form>

<h2>Beschikbare Jachten</h2>
<?php if ($boat_result->num_rows > 0): ?>
    <div class="boat-list">
        <?php while ($boat = $boat_result->fetch_assoc()): ?>
            <div class="boat-card">
                <h3><?php echo htmlspecialchars($boat['name']); ?></h3>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($boat['type']); ?></p>
                <p><strong>Locatie:</strong> <?php echo htmlspecialchars($boat['location']); ?></p>
                <p><strong>Prijs:</strong> €<?php echo htmlspecialchars($boat['price']); ?> per dag</p>
                <p><strong>Beschikbaarheid:</strong> van <?php echo htmlspecialchars($boat['available_from']); ?> tot <?php echo htmlspecialchars($boat['available_to']); ?></p>
                <p><strong>Beschrijving:</strong> <?php echo htmlspecialchars($boat['description']); ?></p>
                <a href="confirm_reservation.php?id=<?php echo $boat['id']; ?>">Reserveer</a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Er zijn momenteel geen jachten beschikbaar in deze locatie.</p>
<?php endif; ?>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="index.php?page=<?php echo $page - 1; ?>&location=<?php echo $location_filter; ?>" class="prev">Vorige</a>
    <?php endif; ?>

    <?php
    $max_buttons = 5; 
    $start = max(1, $page - floor($max_buttons / 2));
    $end = min($total_pages, $start + $max_buttons - 1);

    if ($end - $start + 1 < $max_buttons) {
        $start = max(1, $end - $max_buttons + 1);
    }

    for ($i = $start; $i <= $end; $i++): ?>
        <a href="index.php?page=<?php echo $i; ?>&location=<?php echo $location_filter; ?>" 
           <?php echo ($i == $page) ? 'class="active"' : ''; ?>>
           <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="index.php?page=<?php echo $page + 1; ?>&location=<?php echo $location_filter; ?>" class="next">Volgende</a>
    <?php endif; ?>
</div>

<?php
$conn->close();
include('footer.php');
?>

<style>
    h1, p, h2 {
        text-align: center;
        margin: 0 auto;
        max-width: 800px; 
    }

    .pagination {
        text-align: center;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .pagination a {
        display: inline-block;
        padding: 10px 15px;
        margin: 0 5px;
        text-decoration: none;
        background-color: #f0f0f0;
        color: #333;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .pagination a:hover {
        background-color: #ddd;
    }

    .pagination .active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination .prev,
    .pagination .next {
        font-weight: bold;
    }

    .pagination .prev:hover,
    .pagination .next:hover {
        background-color: #4CAF50;
        color: white;
    }
</style>