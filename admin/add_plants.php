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
    $plant_name = filter_var($_POST['plant_name'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $category_id = intval($_POST['category_id']);
    $supplier_id = intval($_POST['supplier_id']);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO plants (plant_name, description, category_id, supplier_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $plant_name, $description, $category_id, $supplier_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Plant added successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: manage_plants.php");
    exit();
}
?>

