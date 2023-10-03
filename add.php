<?php
session_start();

$message = ""; // Initialize a variable to store the success or error message.

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_SESSION['user_id'];
    $price = $_POST["price"];
    
    // Check if an image was uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $image_name = $_FILES["image"]["name"];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        
        // Generate a unique name for the image
        $image_path = "uploads/" . uniqid() . "." . $image_extension;

        // Move the uploaded image to the desired location
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "app";

            $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO products (title, content, user_id, image_path, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisd", $title, $content, $user_id, $image_path, $price);

            if ($stmt->execute()) {
                $message = "Product added successfully";
            } else {
                $message = "Error: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            $message = "Error moving uploaded image.";
        }
    } else {
        $message = "No image uploaded or an error occurred.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add new product</title>
    <style>
        /* CSS for styling the success message */
        .success-message {
            background-color: green;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include "header.php"; ?><br>
<h2>Add</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br>

    <label for="content">Content:</label>
    <textarea name="content" id="content" required></textarea><br>

    <label for="image">Image:</label>
    <input type="file" name="image" id="image" required><br><br>

    <label for="price">Price:</label>
    <input type="number" class="price" name="price" id="price" required><br>

    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    
    <input type="submit" value="Submit">
</form><br><br><br>
<?php
if (!empty($message)) {
    echo '<div class="success-message">' . $message . '</div>';
}
?>
</body>
</html>

