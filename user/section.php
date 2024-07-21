<?php
global $conn;
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$category_id = $_GET['category_id'];
$sql = "SELECT * FROM Plants WHERE category_id = $category_id";
$result = $conn->query($sql);

$category_name = '';
switch ($category_id) {
    case 1:
        $category_name = 'Industrial Plants';
        break;
    case 2:
        $category_name = 'Chemical Plants';
        break;
    case 3:
        $category_name = 'Gardening Plants';
        break;
    case 4:
        $category_name = 'Medicinal Plants';
        break;
    case 5:
        $category_name = 'Scientific Plants';
        break;
    default:
        header("Location: dashboard.php");
        exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $category_name; ?></title>
</head>
<body>
<h1><?php echo $category_name; ?></h1>
<ul>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <li>
            <h2><?php echo $row['plant_name']; ?></h2>
            <p><?php echo $row['description']; ?></p>
        </li>
    <?php } ?>
</ul>
<div>
    <a href="apply_for_plant.php?category_id=<?php echo htmlspecialchars($category_id); ?>">Apply for plant</a>
</div>
<div>
<a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>