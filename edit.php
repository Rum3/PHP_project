<?php
session_start();

// Проверка дали потребителят е влезнал в системата
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Пренасочете потребителя към страницата за вход, ако не е влезнал
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

// Проверка и извличане на идентификационния номер на обявата от URL
if (isset($_GET['ad_id'])) {
    $ad_id = $_GET['ad_id'];

    // Извлечение на информацията за обявата от базата данни
    $sql = "SELECT * FROM ads WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $ad_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Обявата е намерена - извлечете информацията за редакция
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $image_path = $row['image_path'];
    } else {
        // Обявата не съществува или не принадлежи на текущия потребител
        echo "Обявата не съществува или не принадлежи на вас.";
        exit();
    }

    $stmt->close();
} else {
    // Не е предоставен идентификационен номер на обявата в URL
    echo "Идентификационният номер на обявата липсва в URL.";
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

<h1>Edit Ad</h1>
<div class="containerEdit">
<form method="post" action="updateAd.php">
    <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
    <label for="content">Content:</label>
    <textarea id="content" name="content"><?php echo $content; ?></textarea><br>
    <!-- Визуализация на текущата снимка (по избор) -->
    <?php if (!empty($image_path)) : ?>
        <img src="<?php echo $image_path; ?>" alt="Обява със снимка"><br>
    <?php endif; ?><br>
    <label for="new_image">New Image (optional):</label>
    <input type="file" id="new_image" name="new_image"><br>
    <input type="submit" value="Save">
</form>
</div>
</body>
</html>
