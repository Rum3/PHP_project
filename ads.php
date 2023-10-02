<?php
session_start();


$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "app";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Извлечение на обявите от базата данни
// Извлечение на всички обяви от базата данни
$sql = "SELECT * FROM ads";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ADS</title>
</head>
<body>
<?php include "header.php"; ?><br>
<h1 class="ads-header">ADS</h1>
<div class="container">

<?php
// Показване на обявите
while ($row = $result->fetch_assoc()) {
    echo "<div class='ad-container'>";
    echo "<h2 class='ad-title'>" . $row['title'] . "</h2>";
    echo "<img src='" . $row['image_path'] . "' alt='Обява със снимка' class='ad-image'>";
    echo "<p class='ad-description'>" . $row['content'] . "</p>";
    echo "<a href='edit.php?ad_id=" . $row['id'] . "' class='edit-link'>Edit</a>"; // Бутон за редакция с препратка към edit.php
    echo "</div>";
}
$conn->close();
?>

</body>
</html>
