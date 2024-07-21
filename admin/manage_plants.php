<?php
global $conn;
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM plants";
$result = $conn->query($sql);

$categories_result = $conn->query("SELECT * FROM categories");

$suppliers_result = $conn->query("SELECT * FROM suppliers");

$products_result = $conn->query("SELECT * FROM products");

$orders_result = $conn->query("
    SELECT o.order_id, a.username, p.product_name, s.supplier_name, o.quantity, o.order_date
    FROM orders o
    JOIN admins a ON o.admin_id = a.admin_id
    JOIN products p ON o.product_id = p.product_id
    JOIN suppliers s ON o.supplier_id = s.supplier_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Plants</title>
</head>
<body>
<h1>Manage Plants</h1>

<h2>Current Plants</h2>
<table border="1">
    <tr>
        <th>Plant ID</th>
        <th>Plant Name</th>
        <th>Description</th>
        <th>Category Name</th>
        <th>Supplier Name</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) {
        $category_name = 'Unknown';
        if (!empty($row['category_id'])) {
            $cat_result = $conn->query("SELECT category_name FROM categories WHERE category_id = " . intval($row['category_id']));
            if ($cat_result && $cat_result->num_rows > 0) {
                $category_name = $cat_result->fetch_assoc()['category_name'];
            }
        }

        $supplier_name = 'Unknown';
        if (!empty($row['supplier_id'])) {
            $sup_result = $conn->query("SELECT supplier_name FROM suppliers WHERE supplier_id = " . intval($row['supplier_id']));
            if ($sup_result && $sup_result->num_rows > 0) {
                $supplier_name = $sup_result->fetch_assoc()['supplier_name'];
            }
        }
        ?>
        <tr>
            <td><?php echo $row['plant_id']; ?></td>
            <td><?php echo $row['plant_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $category_name; ?></td>
            <td><?php echo $supplier_name; ?></td>
            <td>
                <form action="remove_plant.php" method="POST" style="display:inline;">
                    <input type="hidden" name="plant_id" value="<?php echo $row['plant_id']; ?>">
                    <input type="submit" value="Remove">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<h2>Add New Plant</h2>
<form action="add_plants.php" method="POST">
    <label for="plant_name">Plant Name:</label>
    <input type="text" id="plant_name" name="plant_name" required>
    <br>
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id" required>
        <?php while ($cat_row = $categories_result->fetch_assoc()) { ?>
            <option value="<?php echo $cat_row['category_id']; ?>"><?php echo $cat_row['category_name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <label for="supplier_id">Supplier:</label>
    <select id="supplier_id" name="supplier_id" required>
        <?php while ($sup_row = $suppliers_result->fetch_assoc()) { ?>
            <option value="<?php echo $sup_row['supplier_id']; ?>"><?php echo $sup_row['supplier_name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <input type="submit" value="Add Plant">
</form>

<h2>Place an Order</h2>
<form action="place_order.php" method="POST">
    <label for="product_id">Product:</label>
    <select id="product_id" name="product_id" required>
        <?php while ($prod_row = $products_result->fetch_assoc()) { ?>
            <option value="<?php echo $prod_row['product_id']; ?>"><?php echo $prod_row['product_name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <label for="supplier_id">Supplier:</label>
    <select id="supplier_id" name="supplier_id" required>
        <?php
        $suppliers_result = $conn->query("SELECT * FROM suppliers");
        if (!$suppliers_result) {
            die("Error fetching suppliers for order: " . $conn->error);
        }

        while ($sup_row = $suppliers_result->fetch_assoc()) { ?>
            <option value="<?php echo $sup_row['supplier_id']; ?>"><?php echo $sup_row['supplier_name']; ?></option>
        <?php } ?>
    </select>
    <br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required>
    <br>
    <input type="submit" value="Place Order">
</form>

<h2>Current Orders</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Admin</th>
        <th>Product</th>
        <th>Supplier</th>
        <th>Quantity</th>
        <th>Order Date</th>
    </tr>
    <?php while ($order_row = $orders_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $order_row['order_id']; ?></td>
            <td><?php echo $order_row['username']; ?></td>
            <td><?php echo $order_row['product_name']; ?></td>
            <td><?php echo $order_row['supplier_name']; ?></td>
            <td><?php echo $order_row['quantity']; ?></td>
            <td><?php echo $order_row['order_date']; ?></td>
        </tr>
    <?php } ?>
</table>

<a href="admin.php">Back to Dashboard</a>
</body>
</html>

<?php
$conn->close();
?>
