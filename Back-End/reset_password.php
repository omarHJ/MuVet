<?php
session_start(); // Start the session to access session variables

// Function to update password in the database
function updatePassword($conn, $tableName, $password, $token) {
    // Escape special characters to prevent SQL injection
    $password = $conn->real_escape_string($password);
    $token = $conn->real_escape_string($token);

    // Hash the password before storing it in the database (you should use a secure hashing algorithm like bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE $tableName SET password = '$hashedPassword', reset_token = NULL WHERE reset_token = '$token'";
    if ($conn->query($sql) === TRUE) {
        return true; // Password updated successfully
    } else {
        return false; // Error updating password
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate token
    if (!isset($_POST['token']) || empty($_POST['token'])) {
        echo "Invalid token.";
        exit;
    }

    // Retrieve token from the form
    $token = $_POST['token'];

    // Database connection credentials for both databases
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname1 = "signup_staff";
    $dbname2 = "signup_clients";

    // Create connection for both databases
    $conn1 = new mysqli($servername, $username, $password, $dbname1);
    $conn2 = new mysqli($servername, $username, $password, $dbname2);

    // Check connection for both databases
    if ($conn1->connect_error || $conn2->connect_error) {
        die("Connection to database failed: " . ($conn1->connect_error ? $conn1->connect_error : $conn2->connect_error));
    }

    // Retrieve password and confirm password from the form
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Query to retrieve user information based on the token from the first database
    $sql1 = "SELECT * FROM doctors WHERE reset_token = '$token'";
    $result1 = $conn1->query($sql1);

    // Query to retrieve user information based on the token from the second database
    $sql2 = "SELECT * FROM clients WHERE reset_token = '$token'";
    $result2 = $conn2->query($sql2);

    // Update password in the first database if token is found
    if ($result1->num_rows > 0 && updatePassword($conn1, 'doctors', $password, $token)) {
        echo "Password updated successfully.";
    }
    // Update password in the second database if token is found
    elseif ($result2->num_rows > 0 && updatePassword($conn2, 'clients', $password, $token)) {
        echo "Password updated successfully.";
    } else {
        echo "Password update failed."; // Password update failed (token not found or error updating)
    }

    // Close connections
    $conn1->close();
    $conn2->close();
} else {
    // If the form is not submitted via POST method, redirect to an error page or display an error message
    //echo "Invalid request.";
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C5F1EB;
        }
        form {
            background-color: #a6d1f9;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type=password] {
            width: 95%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #3296f3;
            color: white;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0b6ec8;
        }
    </style>
</head>
<body>

    <h2>Password Reset</h2>
    <form action="" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="password">Enter your new password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm your new password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
