<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize cart items and total price
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .cart-container {
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            max-width: 100px;
            margin-right: 20px;
            border-radius: 5px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item h5 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .cart-item p {
            margin: 0;
            color: #777;
        }

        .cart-total {
            text-align: right;
            margin-top: 20px;
        }

        .cart-total h3 {
            font-size: 22px;
            color: #333;
        }

        .checkout-button {
            margin-top: 20px;
            text-align: right;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .cart-empty {
            text-align: center;
            margin-top: 50px;
            font-size: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container cart-container">
        <h1>Your Cart</h1>
        
        <?php if (count($cart_items) > 0) { ?>
            <div class="cart-list">
                <?php foreach ($cart_items as $item) { 
                    $total_price += $item['price'] * $item['quantity'];
                ?>
                    <div class="cart-item">
                        
                        <!-- <img src="uploads/<?php echo isset($item['photo']) ? htmlspecialchars($item['photo']) : 'default.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="cart-item-details"> -->


                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p>Price: $<?php echo htmlspecialchars($item['price']); ?></p>
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <p>Total: $<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="cart-total">
                <h3>Total Price: $<?php echo htmlspecialchars($total_price); ?></h3>
            </div>
            <div class="checkout-button">
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </div>
        <?php } else { ?>
            <div class="cart-empty">
                <p>Your cart is empty.</p>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
