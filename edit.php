<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "app";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['ad_id'])) {
    $ad_id = $_GET['ad_id'];

    $sql = "SELECT * FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $ad_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $image_path = $row['image_path'];
        $price = $row['price'];
    } 

    $stmt->close();
} else {
    echo "not found";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit</title>
</head>
<body>
<?php include "header.php"; ?><br>

<h1>Edit product</h1>
<div class="containerEdit">
<form method="post" action="updateAd.php">
    <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
    <label for="content">Content:</label>
    <textarea id="content" name="content"><?php echo $content; ?></textarea><br>
    <?php if (!empty($image_path)) : ?>
        <img src="<?php echo $image_path; ?>" alt="Обява със снимка"><br>
    <?php endif; ?><br>
    <label for="new_image">New Image (optional):</label>
    <input type="file" id="new_image" name="new_image"><br>
    <label for="price">Price:</label>
    <input type="number" class="price" name="price" id="price"  value="<?php echo $price; ?>" required><br>
    <input type="submit" value="Save">
</form>
</div>
</body>
</html>
