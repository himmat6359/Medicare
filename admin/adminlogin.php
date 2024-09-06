<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and escape user input
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    // Prepare and execute SQL query
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user information in session
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            echo "<script>
                    alert('Login successful!');
                    window.location.href='adminpage.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid password!');
                    window.location.href = 'adminlogin.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with that username!');
                window.location.href = 'adminlogin.html';
              </script>";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
