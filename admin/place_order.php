<?php
global $conn;
session_start();
include 'db.php';

if (!isset($_SESSION['role'] != 'admin') {
    header("Location: admin.php");
    exit();
}

$product_id = intval($_POST['product_id']);
$supplier_id = intval($_POST['supplier_id']);
$quantity = intval($_POST['quantity']);
$username = $_SESSION['username'];

if ($product_id <= 0 || $supplier_id <= 0 || $quantity <= 0) {
    die("Invalid input.");
}

$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

if (!$admin_id) {
    error_log("Admin ID not set in session.");
    die("Admin ID not set.");
}

$sql = "INSERT INTO orders (admin_id, product_id, supplier_id, quantity, order_date) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $admin_id, $product_id, $supplier_id, $quantity);

if ($stmt->execute()) {
    echo "Order placed successfully.";
    header("Location: manage_plants.php");
} else {
    echo "Error placing order: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
