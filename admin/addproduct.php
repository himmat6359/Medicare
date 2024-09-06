<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location:adminregister.html");
    exit();
}
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productRating = $_POST['productRating'];

    // Handling file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["productPhoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // // Check if image file is an actual image or fake image
    // $check = getimagesize($_FILES["productPhoto"]["tmp_name"]);
    // if ($check !== false) {
    //     $uploadOk = 1;
    // } else {
    //     // echo "File is not an image.";
    //     echo "<script>
    //          alert('File is not an image.');
    //          window.location.href='addproduct.html';
    //          </script>";
    //     $uploadOk = 0;
    // }

    // Check if file already exists
    // if (file_exists($targetFile)) {
    //     // echo "Sorry, file already exists.";
    //     echo "<script>
    //      alert('Sorry, file already exists');
    //      window.location.href='addproduct.html';
    //      </script>";
    //     $uploadOk = 0;
    // }

    // Check file size
    // if ($_FILES["productPhoto"]["size"] > 500000) {
    //     // echo "Sorry, your file is too large.";
    //     echo "<script>
    //       alert('Sorry, your file is too large');
    //       window.location.href='addproduct.html';
    //       </script>";
    //     $uploadOk = 0;
    // }

    // // Allow certain file formats
    // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif") {
    //     // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

    //      echo "<script>
    //      alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed');
    //      window.location.href='addproduct.html';
    //      </script>";

    //     $uploadOk = 0;
    // }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.";
        echo "<script>
               alert('Sorry, your file was not uploaded.');
               window.location.href='addproduct.html';
               </script>";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["productPhoto"]["tmp_name"], $targetFile)) {
            $productPhoto = basename($_FILES["productPhoto"]["name"]);

            // Insert product into database
            $stmt = $conn->prepare("INSERT INTO products1 (name, photo, price, rating) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $productName, $productPhoto, $productPrice, $productRating);

            if ($stmt->execute()) {
                   echo "<script>
                   alert('The product has been added successfully.');
                   window.location.href = 'addproduct.html';
                   </script>";


            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // echo "Sorry, there was an error uploading your file.";
            echo "<script>
            alert('Sorry, there was an error uploading your file');
            window.location.href='addproduct.html';
            </script>";
        }
    }
}

$conn->close();
?>
