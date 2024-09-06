<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order_id'])) {
    $delete_order_id = $_POST['delete_order_id'];
    
    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_order_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    
    // Optionally, you might want to delete related order items as well
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $delete_order_id);
    $stmt->execute();
    $stmt->close();
    
    // Redirect to the same page to refresh the list
    header("Location: order_history.php");
    exit();
}

// Fetch orders for the current user
$user_id = $_SESSION['user_id'];
$sql = "SELECT o.id, o.name, o.address, o.contact, o.created_at, p.name AS product_name, p.price
        FROM orders o
        INNER JOIN order_items oi ON o.id = oi.order_id
        INNER JOIN products1 p ON oi.product_id = p.id
        WHERE o.user_id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body><hr>
<button class="button" onclick="window.location.href='adminpage.php'">Back</button>

    <div class="container mt-4">
        <h3>Order History </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['name']; ?></td>
                        <td><?php echo $order['address']; ?></td>
                        <td><?php echo $order['contact']; ?></td>
                        <td><?php echo $order['product_name']; ?></td>
                        <td>₹<?php echo $order['price']; ?></td>
                        <td><?php echo $order['created_at']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_order_id" value="<?php echo $order['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
