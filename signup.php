<?php include('header.php'); ?>

<h2>Registreren</h2>

<form action="signup.php" method="POST">
    <label for="name">Naam</label>
    <input type="text" name="name" id="name" required>

    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Wachtwoord</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" value="Registreren">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "projectp5");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registratie succesvol!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<?php include('footer.php'); ?>