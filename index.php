<?php

$db_host = "10.0.0.52";
$db_name = "loginapp";
$db_user = "appuser";
$db_pass = "YOUR_DATABASE_PASSWORD";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed");
}

$conn->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL
    )
");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "INSERT INTO users (username, password) VALUES (?, ?)"
    );

    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Cloud 3-Tier Web Application</title>
</head>

<body>

<h2>Register</h2>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>

    <button type="submit">Register</button>

</form>

<p><?php echo $message; ?></p>

</body>

</html>