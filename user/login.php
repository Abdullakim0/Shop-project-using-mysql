<?php
global $conn;
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $result = $conn->query("SELECT * FROM admins WHERE username = '$username' AND password = '$password'");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $row['admin_id']; // Store admin_id in session
        header("Location: admin.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
            exit();

        }
    }
    echo "invalid credentials";


    $stmt->close();
    $conn->close();
}
?>
