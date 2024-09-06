<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registered Users - Medion</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    .table-container {
      margin-top: 30px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .alert {
      margin-top: 20px;
    }

    .container {
      max-width: 900px;
    }

    .table thead th {
      background-color: #343a40;
      color: white;
    }
  </style>
</head>
<body><br>
<button class="button" onclick="window.location.href='adminpage.php'">Back</button>

  <div class="container mt-5">
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'medical');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch users data
    $sql = "SELECT id, username, mobile, address FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='table-container'>
                <h2>Registered Users</h2>
                <table class='table table-bordered'>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Mobile</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["username"]) . "</td>
                    <td>" . htmlspecialchars($row["mobile"]) . "</td>
                    <td>" . htmlspecialchars($row["address"]) . "</td>
                  </tr>";
        }
        echo "  </tbody>
              </table>
            </div>";
    } else {
        echo "<div class='mt-5'><p>No users found</p></div>";
    }

    $conn->close();
    ?>
  </div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>
</html>
