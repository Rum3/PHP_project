<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="registration.php">Регистрация</a></li>
            <li><a href="login.php">Логин</a></li>
        </ul>
    </nav>
</header>
    <h2>Вход</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Потребителско име:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Парола:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Вход">
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Свържете се към базата данни
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "app";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Защита от SQL инжекции (примерно с използване на prepared statements)
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_password_hash);
    $stmt->fetch();

    if (password_verify($password, $db_password_hash)) {
        echo "Добре дошли, $db_username!";
    } else {
        echo "Грешно потребителско име или парола. Моля, опитайте отново.";
    }

    // Затваряме връзката към базата данни
    $stmt->close();
    $conn->close();
}
?>

