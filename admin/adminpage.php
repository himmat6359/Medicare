<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      display: flex;
    }
    .sidebar {
      width: 250px;
      background: #343a40;
      color: #fff;
      position: fixed;
      height: 100%;
      padding: 20px;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px;
      margin: 10px 0;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
      width: 100%;
    }
    .header {
      background: #6c757d;
      color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header .logout, .header .go-home {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="addproduct.html"><i class="fas fa-plus-circle"></i> Add Product</a>
    <a href="feedback.php"><i class="fas fa-cogs"></i> Feed Back</a>
    <a href="order_history.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <h3>Admin Dashboard</h3>
      <div>
        <a href="\medion\index.html" class="go-home"><i class="fas fa-home"></i> Home</a>
        <a href="logout.php" class="logout ml-3"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </div>

    <!-- Content -->
    <div class="container mt-4">
      <h4>Welcome, Admin!</h4>
      <div class="row">
        <div class="col-md-3">
          <div class="card bg-info text-white mb-4">
            <div class="card-body">
              <i class="fas fa-box"></i> Products
              
              <h5 class="card-title">
                <?php
                 session_start();

                 // Check if user is logged in
                 if (!isset($_SESSION['admin_id'])) {
                     header("Location:adminregister.html");
                     exit();
                 }
                  // Database connection
                  $conn = new mysqli('localhost', 'root', '', 'medical');

                  // Check connection
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }
                  
                  // Fetch product count
                  $sql = "SELECT COUNT(*) as count FROM products1";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  $total_products = $row['count'];

                  echo $total_products;
                ?>
              </h5>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">
              <i class="fas fa-shopping-cart"></i> Orders
              <h5 class="card-title">
              <?php

               $sql = "SELECT COUNT(*) as count FROM orders";
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               $total_orders =$row['count'];

               echo $total_orders;
               ?>
              </h5>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-warning text-white mb-4">
            <div class="card-body">
              <i class="fas fa-users"></i> Users
              <h5 class="card-title">
              <?php
               $sql = "SELECT COUNT(*) as count FROM users";
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               $total_user =$row['count'];

               echo $total_user;
               ?>
              </h5>
            </div>
          </div>
        </div>
         
        <div class="col-md-3">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">
              <i class="fas fa-users"></i> Feedback
              <h5 class="card-title">
              <?php
               $sql = "SELECT COUNT(*) as count FROM form_data";
               $result = $conn->query($sql);
               $row = $result->fetch_assoc();
               $total_feedback =$row['count'];

               echo $total_feedback;
               ?>
              </h5>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body">
              <i class="fas fa-dollar-sign"></i> Revenue
              <h5 class="card-title">$5000</h5>
            </div>
          </div>
        </div>
      </div>
      <!-- More content can be added here -->
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
