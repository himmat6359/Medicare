<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
        }
       
        .sidebar a:hover {
            background: #495057;
        }
        .main-content {
            /* margin-left: 250px; */
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
        .header .logout {
            color: #fff;
        }
    </style>
</head>
<body>

  <!-- Sidebar -->
  

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
    <button class="button" onclick="window.location.href='adminpage.php'">Back</button>

      <h3>Admin Dashboard</h3>
      <a href="\medion\index.html" class="go-home"><i class="fas fa-home"></i> Home</a>

      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="container mt-4">
      <h4 class="mt-4">Product List</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Product Photo</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
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

            // Fetch products
            $sql = "SELECT id, name, photo, price, rating FROM products1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td><img src='uploads/" . htmlspecialchars($row["photo"]) . "' alt='Product Photo' width='50'></td>
                        <td>" . htmlspecialchars($row["price"]) . "</td>
                        <td>" . htmlspecialchars($row["rating"]) . " Stars</td>
                        <td>
                          <form method='POST' action='deleteproduct.php' style='display:inline-block;'>
                            <input type='hidden' name='product_id' value='" . htmlspecialchars($row["id"]) . "'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                          </form>
                          <a href='editproduct.php?product_id=" . htmlspecialchars($row["id"]) . "' class='btn btn-primary'>Edit</a>
                        </td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='5'>No products found</td></tr>";
            }
            $conn->close();
          ?>
        </tbody>
      </table>
      
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
