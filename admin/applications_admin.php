<?php
global $conn;
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: admin.php");
    exit();
}

include 'db.php';

$sql = "SELECT a.application_id, u.username, p.plant_name, a.application_date, a.status, a.reply
        FROM applications a
        JOIN Users u ON a.user_id = u.user_id
        JOIN Plants p ON a.plant_id = p.plant_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Applications</title>
</head>
<body>
<h1>View Applications</h1>
<table border="1">
    <tr>
        <th>Application ID</th>
        <th>Username</th>
        <th>Plant Name</th>
        <th>Application Date</th>
        <th>Status</th>
        <th>Reply</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['application_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['plant_name']; ?></td>
            <td><?php echo $row['application_date']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['reply']; ?></td>
            <td>
                <form action="update_application.php" method="POST" style="display: inline;">
                    <input type="hidden" name="application_id" value="<?php echo $row['application_id']; ?>">
                    <select name="status">
                        <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Approved" <?php if($row['status'] == 'Approved') echo 'selected'; ?>>Approved</option>
                        <option value="Rejected" <?php if($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                    </select>
                    <br>
                    <textarea name="reply" placeholder="Write reply..."><?php echo $row['reply']; ?></textarea>
                    <br>
                    <input type="submit" value="Update">
                </form>
                <form action="delete_application.php" method="POST" style="display: inline;">
                    <input type="hidden" name="application_id" value="<?php echo $row['application_id']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>

<?php $conn->close(); ?>
