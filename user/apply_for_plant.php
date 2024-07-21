<?php
global $conn;
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

if ($category_id === 0) {
    header("Location: section.php");
    exit();
}

$sql = "SELECT plant_id, plant_name FROM Plants WHERE category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for a Plant</title>
</head>
<body>
<h1>Apply for a Plant</h1>
<form action="submit_application.php" method="POST">
    <label for="plant">Select Plant:</label>
    <select id="plant" name="plant_id" required>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo htmlspecialchars($row['plant_id']); ?>"><?php echo htmlspecialchars($row['plant_name']); ?></option>
        <?php } ?>
    </select>
    <br>
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
    <input type="submit" value="Apply">
</form>
<a href="section.php">Back to Home</a>
</body>
</html>

<?php $conn->close(); ?>
