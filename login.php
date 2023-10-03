<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="registration.php">Registration</a></li>
        </ul>
    </nav>
</header>
    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "app";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_username, $db_email, $db_password_hash);
    $stmt->fetch();

    if (password_verify($password, $db_password_hash)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['email'] = $db_email;

        header("Location: ads.php");
        exit;
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}

?>

