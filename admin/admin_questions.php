<?php
global $conn;
session_start();
include 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all questions and their respective answers
$sql = "SELECT q.question_id, q.username, q.question, a.answer, a.answer_date
        FROM questions q
        LEFT JOIN answers a ON q.question_id = a.question_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Questions</title>
</head>
<body>
<h1>Manage Questions</h1>
<?php
if (isset($_SESSION['message'])) {
    echo '<p>' . htmlspecialchars($_SESSION['message']) . '</p>';
    unset($_SESSION['message']);
}
?>
<table border="1">
    <tr>
        <th>User</th>
        <th>Question</th>
        <th>Answer</th>
        <th>Answer Date</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['question']); ?></td>
            <td><?php echo htmlspecialchars($row['answer']); ?></td>
            <td><?php echo htmlspecialchars($row['answer_date']); ?></td>
            <td>
                <?php if ($row['answer'] == null) { ?>
                    <form action="submit_answer.php" method="POST">
                        <input type="hidden" name="question_id" value="<?php echo $row['question_id']; ?>">
                        <input type="text" name="answer" required>
                        <input type="submit" value="Submit Answer">
                    </form>
                <?php } else { ?>
                    <p>Answered</p>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>
<a href="admin.php">Back to Admin panel</a>
</body>
</html>

<?php $conn->close(); ?>
