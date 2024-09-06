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

// Handle remove from cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];
    if (isset($_SESSION['cart'])) {
        if (($key = array_search($remove_product_id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            // Reindex array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $_SESSION['success_message'] = "Product removed from cart.";
        }
    }
    header("Location: cart.php");
    exit();
}

// Fetch cart items
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_count = count($cart_items);

// Fetch product details for items in cart
$products_in_cart = [];
$total_price = 0;

if ($cart_count > 0) {
    // Prepare the SQL statement with placeholders
    $placeholders = implode(',', array_fill(0, count($cart_items), '?'));
    $types = str_repeat('i', count($cart_items)); // assuming id is integer

    $sql = "SELECT id, name, price FROM products1 WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);

    // Bind parameters dynamically
    // mysqli requires references for bind_param, so use call_user_func_array
    $params = [];
    $params[] = $types;
    foreach ($cart_items as $item) {
        $params[] = &$item; // references
    }
    call_user_func_array([$stmt, 'bind_param'], $params);

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products_in_cart[] = $row;
        $total_price += $row['price'];
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Optional: Custom styles for better appearance */
        .header {
            background-color: #f8f9fa;
            padding: 15px;
        }
        .badge-danger {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
        }
        .cart-button {
            position: relative;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h3>Your Cart</h3>
            <div>
                <a href="/medion/index.html" class="btn btn-outline-primary mr-2">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="/medion/user/userlogout.php" class="btn btn-outline-danger mr-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <a href="addCart.php" class="btn btn-outline-success cart-button">
                    <i class="fas fa-shopping-cart"></i> Cart 
                    <span class="badge badge-pill badge-danger" id="cart-count"><?php echo $cart_count; ?></span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        <div class="container mt-3">
            <?php
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                    . htmlspecialchars($_SESSION['success_message']) .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                </div>';
                unset($_SESSION['success_message']);
            }
            ?>
        </div>

        <!-- Content -->
        <div class="container mt-4">
            <?php
            if ($cart_count > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead class="thead-light"><tr><th>Product</th><th>Price</th><th>Action</th></tr></thead>';
                echo '<tbody>';

                foreach ($products_in_cart as $product) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                    echo '<td>$' . htmlspecialchars($product['price']) . '</td>';
                    echo '<td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="remove_product_id" value="' . htmlspecialchars($product['id']) . '">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '<h4>Total: $' . number_format($total_price, 2) . '</h4>';
                echo '<button class="btn btn-primary">Checkout</button>';
            } else {
                echo '<p>Your cart is empty.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Scripts -->
    <script>
    // Optional: Add any JavaScript functionality needed for the cart page
    </script>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
