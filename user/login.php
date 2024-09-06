<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $sql = "SELECT id, username, password, mobile, address FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['mobile'] = $user['mobile'];
            $_SESSION['address'] = $user['address'];

            header("Location: /medion/admin/byshop.php");
            exit();
        } else {
            echo "<script>alert('Invalid password')
                window.location.href='user_login.html';
                </script>";

            
        }
    } else {
      
        
echo "<script>
       alert('No data found');
       window.location.href = 'user_login.html';
     </script>";


    }
    $stmt->close();
}
$conn->close();
?>
