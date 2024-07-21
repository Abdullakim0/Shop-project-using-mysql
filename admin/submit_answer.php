<?php
global $conn;
session_start();
include 'db.php';

if (!isset($_SESSION['role'] != 'admin') {
    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = intval($_POST['question_id']);
    $answer = filter_var($_POST['answer'], FILTER_SANITIZE_STRING);
    $answer_date = date('Y-m-d');

    if (empty($answer)) {
        $_SESSION['message'] = "Invalid input.";
        header("Location: admin_questions.php");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO answers (question_id, answer, answer_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss",$question_id,$answer, $answer_date);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Answer submitted successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_questions.php");
    exit();
} else {
    header("Location: admin_questions.php");
    exit();
}
?>
