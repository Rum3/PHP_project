<!DOCTYPE html>
<html>
<head>
    <title>registration</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="registration.php">Registration</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>
    <h2>Registration</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="username">Name</label>
        <input type="text" name="username" required><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "app";

        $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

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
    }
    ?>
