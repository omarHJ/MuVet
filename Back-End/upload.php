<?php
// Database connection credentials for first database
$servername1 = "localhost";
$username1 = "root";
$password1 = "";
$dbname1 = "signup_staff";

// Create connection for first database
$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);

// Check connection for first database
if ($conn1->connect_error) {
    die("Connection to first database failed: " . $conn1->connect_error);
}

// Database connection credentials for second database
$servername2 = "localhost";
$username2 = "root";
$password2 = "";
$dbname2 = "signup_clients"; // Change this to your second database name

// Create connection for second database
$conn2 = new mysqli($servername2, $username2, $password2, $dbname2);

// Check connection for second database
if ($conn2->connect_error) {
    die("Connection to second database failed: " . $conn2->connect_error);
}

session_start(); // Start the session to access session variables

if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // Update image data in the first database for the current user
        $sql1 = "UPDATE doctors SET imgs = '".$imgContent."' WHERE full_name = '{$_SESSION['username']}'";

        if($conn1->query($sql1) === TRUE){
            echo "Image updated successfully in first database.";
        } else {
            echo "Error updating image in first database: " . $sql1 . "<br>" . $conn1->error;
        }

        // Update image data in the second database for the current user
        $sql2 = "UPDATE clients SET imgs = '".$imgContent."' WHERE full_name = '{$_SESSION['username']}'";

        if($conn2->query($sql2) === TRUE){
            echo "Image updated successfully in second database.";
        } else {
            echo "Error updating image in second database: " . $sql2 . "<br>" . $conn2->error;
        }
    } else {
        echo "File is not an image. or the picture is bigger than 2MG";
    }
} else {
    echo "No file uploaded or file upload error.";
}

// Close connections
$conn1->close();
$conn2->close();
?>
