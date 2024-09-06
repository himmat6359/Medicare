<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    include 'conn.php';
    // Retrieve form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $medicine = $_POST['medicine'];
    $message = $_POST['message'];

    // Prepare SQL query
    $sql = "INSERT INTO form_data (name, phone, email, medicine, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssss", $name, $phone, $email, $medicine, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Feedback Stored successfully!');
                window.location.href='index.html';
                </script>";
                
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
