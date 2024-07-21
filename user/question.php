<?php
global $conn;
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $question = filter_var($_POST['question'], FILTER_SANITIZE_STRING);

    // Check if the inputs are valid
    if (empty($username) || empty($question)) {
        echo "Invalid input.";
        exit();
    }

    // Prepare SQL statement to insert question
    $stmt = $conn->prepare("INSERT INTO questions (username, question) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $question);

    if ($stmt->execute()) {
        echo "Question submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
</head>
<body>
<h1>Questions and Queries</h1>
<form action="question.php" method="POST">
    <label for="username">Full Name:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="question">Question:</label>
    <input type="text" id="question" name="question" required>
    <br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
