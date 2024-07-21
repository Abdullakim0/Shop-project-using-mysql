<?php
include 'login.php';

if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
<h1>Welcome to the Plant Shop, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<nav>
    <ul>
        <li><a href="section.php?category_id=1">Industrial Plants</a></li>
        <li><a href="section.php?category_id=2">Chemical Plants</a></li>
        <li><a href="section.php?category_id=3">Gardening Plants</a></li>
        <li><a href="section.php?category_id=4">Medicinal Plants</a></li>
        <li><a href="section.php?category_id=5">Scientific Plants</a></li>
    </ul>
</nav>
</body>
</html>
