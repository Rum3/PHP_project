<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "app";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $ad_id = $_POST['ad_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidii", $title, $content, $price, $ad_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: myAds.php");
        exit();
    } else {
        echo "error" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error";
}
?>