<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<button class="button" onclick="window.location.href='adminpage.php'">Back</button>
        
<?php

session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location:adminregister.html");
//     exit();
// }
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medical";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT * FROM form_data";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Output table header
    echo "<table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Medicine</th>
                <th>Message</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"]. "</td>";
        echo "<td>" . $row["phone"]. "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td>" . $row["medicine"]. "</td>";
        echo "<td>" . $row["message"]. "</td>";
        echo "</tr>";
    }

    // Close the table
    echo "</table>";
} else {
    echo "0 results";
}

// Close database connection
$conn->close();
?>
</body>
</html>
