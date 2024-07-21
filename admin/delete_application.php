<?php
global $conn;
include 'db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = $_POST['application_id'];

    $sql = "DELETE FROM Applications WHERE application_id = $application_id";

    if ($conn->query($sql) === TRUE) {
        echo "Application deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: applications_admin.php");
}
?>
