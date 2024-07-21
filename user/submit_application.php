<?php
global $conn;
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $plant_id = $_POST['plant_id'];
    $application_date = date('Y-m-d');
    $status = 'Pending'; // Initial status

    $stmt = $conn->prepare("INSERT INTO Applications (user_id, plant_id, application_date, status) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Failed to prepare the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("iiss", $user_id, $plant_id, $application_date, $status);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Application submitted successfully!";
        header("Location: success.php");
        exit();
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
