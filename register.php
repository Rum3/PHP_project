<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "app";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Грешка при връзката с базата данни: " . mysqli_connect_error());
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "Регистрацията е успешна!";
    } else {
        echo "Грешка при регистрацията: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
