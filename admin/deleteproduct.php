<?php
// session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Check if product_id is set
// if (!isset($_POST['product_id'])) {
//     header("Location: dashboard.php");
//     exit();
// }

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = intval($_POST['product_id']);

// Delete product
$sql = "DELETE FROM products1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

$conn->close();
echo "<script>
alert('This Product Successfull Deleted..');
window.location.href='dashboard.php';
</script>";
// header("Location:dashboard.php");
exit();
?>
