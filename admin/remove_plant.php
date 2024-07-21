<?php
global $conn;
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login_user.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plant_id = intval($_POST['plant_id']);

    // Prepare SQL statement
    $stmt = $conn->prepare("DELETE FROM plants WHERE plant_id = ?");
    $stmt->bind_param("i", $plant_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Plant removed successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: manage_plants.php");
    exit();
}
?>
