<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add to cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Ensure cart is an array
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if (is_array($item) && $item['id'] == $product_id) {
            $item['quantity'] += 1; // Increase quantity if already in the cart
            $found = true;
            break;
        }
    }

    // If not found, add new product to cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
    }

    header("Location: byshop.php");
    exit();
}

// Calculate cart item count
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item)) { // Ensure $item is an array before accessing its elements
            $cart_count += $item['quantity'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h3>Product List</h3>
            <a href="\medion/index.html" class="go-home"><i class="fas fa-home"></i> Home</a>
            <a href="\medion/user/userlogout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <a href="cart.php" class="btn btn-outline-success cart-button">
                <i class="fas fa-shopping-cart"></i> Cart 
                <span class="badge badge-pill badge-danger" id="cart-count"><?php echo $cart_count; ?></span>
            </a>
        </div>

        <!-- Content -->
        <div class="container mt-4">
            <div class="row">
                <?php
                // Fetch products
                $sql = "SELECT id, name, photo, price, rating FROM products1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='col-md-4'>
                                <div class='card product-card'>
                                    <img src='uploads/" . htmlspecialchars($row["photo"]) . "' class='card-img-top' alt='Product Photo'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . htmlspecialchars($row["name"]) . "</h5>
                                        <p class='card-text'>Price: $" . htmlspecialchars($row["price"]) . "</p>
                                        <p class='card-text'>Rating: " . htmlspecialchars($row["rating"]) . " Stars</p>
                                        <form method='POST' action=''>  
                                            <input type='hidden' name='product_id' value='" . htmlspecialchars($row["id"]) . "'>
                                            <input type='hidden' name='product_name' value='" . htmlspecialchars($row["name"]) . "'>
                                            <input type='hidden' name='product_price' value='" . htmlspecialchars($row["price"]) . "'>
                                            <button type='submit' class='btn btn-primary' id='shop'>Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<div class='col-12'><p>No products found</p></div>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
