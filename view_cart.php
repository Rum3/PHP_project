<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CART</title>
</head>
<body>
    
<?php include "header.php"; ?><br>
<?php
session_start();

$message = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Your cart is empty.";
} else {
    echo "<h1>CART:</h1>";
    echo "<ul>";

    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "app";

    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $totalPrice = 0;


    foreach ($_SESSION['cart'] as $product_id) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "<li class='cart-product'>
            <div class='product-info'>
                <span class='product-title'>" . $row['title'] . "</span>
                <span class='product-price'>$" . $row['price'] . "</span>
            </div>
            <form class='remove-form' method='post'>
                <input type='hidden' name='remove_id' value='$product_id'>
                <input class='remove-button' type='submit' name='remove' value='Remove'>
            </form>
        </li>";
        $totalPrice += $row['price'];
        }
    }
    echo "<p>Total Price: $" . $totalPrice . "</p>";

    if (isset($_POST['remove'])) {
        $remove_id = $_POST['remove_id'];
        $index = array_search($remove_id, $_SESSION['cart']);
    
        if ($index !== false) {
            unset($_SESSION['cart'][$index]);
        }
    
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    mysqli_close($conn);
    echo "</ul>";
    echo "<button class='buy-button' onclick='checkout()'>BUY</button>";

}
?>
</body>
</html>
<style>
.cart-product {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 18px;
    margin-bottom: 5px;
}

.product-price {
    color: #555;
}

.remove-form {
    margin-left: 10px;
}

.remove-button {
    background-color: #ff0000;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.remove-button:hover {
    background-color: #cc0000;
}

.buy-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}

.buy-button:hover {
    background-color: #0056b3;
}

.buy-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 10px; 
}

.buy-button:hover {
    background-color: #0056b3;
}

</style>




