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
    $question_id = intval($_POST['question_id']);
    $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);
    $answer_date = date('Y-m-d');

    // Check if the inputs are valid
    if (empty($answer)) {
        $_SESSION['message'] = "Invalid input.";
        header("Location: admin_questions.php");
        exit();
    }

    // Prepare SQL statement to insert answer
    $stmt = $conn->prepare("INSERT INTO answers (question_id, answer, answer_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss",$question_id,$answer, $answer_date);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Answer submitted successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the admin questions page
    header("Location: admin_questions.php");
    exit();
} else {
    // Redirect to admin questions page if the request method is not POST
    header("Location: admin_questions.php");
    exit();
}
?>
