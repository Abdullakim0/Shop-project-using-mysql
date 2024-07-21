<?php
global $conn;
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login_user.php");
    exit();
}

// Validate input
$product_id = intval($_POST['product_id']);
$supplier_id = intval($_POST['supplier_id']);
$quantity = intval($_POST['quantity']);
$username = $_SESSION['username']; // Admin's username from session

// Check if inputs are valid
if ($product_id <= 0 || $supplier_id <= 0 || $quantity <= 0) {
    die("Invalid input.");
}

// Retrieve admin ID from session
$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

if (!$admin_id) {
    // Handle case where admin ID is not available
    error_log("Admin ID not set in session.");
    die("Admin ID not set.");
}

// Place the order
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
