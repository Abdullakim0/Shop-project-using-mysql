<?php
include 'login.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
</head>
<body>
<h1>Admin Panel</h1>
<div>
    <a href="applications_admin.php">View Applications</a>
</div>
<div>
    <a href="admin_questions.php">View Questions</a>
</div>
<div>
    <a href="manage_plants.php">Plant management</a>
</div>
</body>
</html>
