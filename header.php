<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<header>
    <nav>
        <ul class="nav-left">
            <li>User: <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'GUEST'; ?></li>    
            <?php if (isset($_SESSION['username'])) : ?>
                <li><a href="add.php">Add ads</a></li>
            <?php endif; ?>
            <li><a href="ads.php">Ads</a></li>
            <?php if (isset($_SESSION['username'])) : ?>
                <li><a href="myAds.php">My ads</a></li>
            <?php endif; ?>
        </ul>
        <ul class="nav-right">
        <?php if (isset($_SESSION['username'])) : ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else : ?>
            <li><a href="index.php">Home</a></li>
        <?php endif; ?>
        </ul>
    </nav>
</header><br>
</body>

</html>

