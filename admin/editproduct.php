<?php
session_start();

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$sql = "SELECT id, name, photo, price, rating FROM products1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $photo = $product['photo'];

    // Check if a new photo is uploaded
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo = $_FILES["photo"]["name"];
    }

    // Update product details in the database
    $sql = "UPDATE products1 SET name = ?, price = ?, rating = ?, photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdisi", $name, $price, $rating, $photo, $product_id);
    $stmt->execute();
    $stmt->close();

    header("Location:dashboard.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h3>Edit Product</h3>
        <?php if ($product): ?>
            <form method="POST" action="editproduct.php?product_id=<?php echo $product_id; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <input type="number" step="0.1" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($product['rating']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="photo">Product Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                    <img src="uploads/<?php echo htmlspecialchars($product['photo']); ?>" alt="Product Photo" width="100" class="mt-2">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
