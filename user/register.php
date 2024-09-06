<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'medical');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Insert user details into the database
    $sql = "INSERT INTO users (username, password, mobile, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $mobile, $address);

    if ($stmt->execute()) {
        // echo "Registration successful";
        // header("Location:user_login.html");
        header("Location:user_login.html");

        echo "<script>alert('Registration successful')</script>";


    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
