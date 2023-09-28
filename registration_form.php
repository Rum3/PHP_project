<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form action="register.php" method="post">
        <label for="username">Потребителско име:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">Имейл:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Парола:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Регистрирай се">
    </form>
</body>
</html>
