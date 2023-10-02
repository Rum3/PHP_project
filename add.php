<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_SESSION['user_id'];

    // Обработка на качената снимка
    $upload_dir = "uploads/"; // Папка, където ще се запази снимката
    $image_name = $_FILES["image"]["name"];
    $image_tmp_name = $_FILES["image"]["tmp_name"];
    
    $image_path = $upload_dir . $image_name;

    if (move_uploaded_file($image_tmp_name, $image_path)) {
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "app";

        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO ads (title, content, user_id, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $content, $user_id, $image_path);

        if ($stmt->execute()) {
            echo "Обявата е успешно добавена!";
        } else {
            echo "Грешка при добавяне на обявата: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Грешка при качване на снимката.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>dashboard</title>
</head>
<body>
<?php include "header.php"; ?><br>
<h2>Add</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required></textarea><br>

    <label for="image">image:</label>
    <input type="file" name="image" id="image"><br><br>

    <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id']; ?>">
    
    <input type="submit" value="Submit">
</form>


</body>
</html>

