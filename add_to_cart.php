<?php
session_start();

if(isset($_GET['ad_id'])) {
    $ad_id = $_GET['ad_id'];

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $_SESSION['cart'][] = $ad_id;

    header("Location: ads.php");
    exit();
} else {
    header("Location: ads.php");
    exit();
}
?>
