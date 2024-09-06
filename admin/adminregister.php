<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the number of registered admins
    $check_sql = "SELECT COUNT(*) AS admin_count FROM admins";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();
    
    if ($row['admin_count'] >= 3) {
        echo "<script>alert('Registration limit reached. Only 3 admin registrations allowed.');
        window.location.href='adminregister.html';
        </script>";
    } else {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful');
                    window.location.href='adminlogin.html';
                    </script>";
        } else {
            echo "Error: " . $stmt->err
            
            
            or;
        }
        $stmt->close();
    }
    $conn->close();
}

?>