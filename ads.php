<?php
session_start();


$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "app";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Products</title>
</head>
<body>

<?php include "header.php"; ?><br>

    <div class="cart-container">
        <a class="cart-link" href="view_cart.php">View Cart</a>
        <p class="cart-message">
            <?php
            if (!empty($_SESSION['cart'])) {
                echo "Number of items in your cart: " . count($_SESSION['cart']);
            } else {
                echo "Your cart is empty";
            }
            ?>
        </p>
    </div>

<h1 class="ads-header">PRODUCTS</h1>
<div class="container">
<?php
while ($row = $result->fetch_assoc()) {
    echo "<div class='ad-container'>";
    echo "<h2 class='ad-title'>" . $row['title'] . "</h2>";
    echo "<img src='" . $row['image_path'] . "' alt='Обява със снимка' class='ad-image'>";
    echo "<p class='ad-description'>" . $row['content'] . "</p>";
    echo "<p class='ad-price'>$" . $row['price'] . "</p>";
    echo "<a href='add_to_cart.php?ad_id=" . $row['id'] . "' class='add-to-cart-link'>Add to Cart</a>";
    echo "</div>";
}
$conn->close();
?>


</body>
</html>
