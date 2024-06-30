<?php
// Function to send password reset email
function sendPasswordResetEmail($to, $token) {
    $subject = 'Password Reset';
    $message = 'You have requested a password reset. Please click the link below to reset your password:
    http://localhost/MuVet/Back-end/reset_password.php?token=' . $token;

    // Additional headers
    $headers = 'From: your@example.com' . "\r\n" .
               'Reply-To: your@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get email entered by user
    $email = $_POST['email'];

    // Check if email exists in the first database (signup_staff)
    $sql1 = "SELECT * FROM doctors WHERE email = '$email'";
    $result1 = $conn1->query($sql1);

    // Check if email exists in the second database (signup_clients)
    $sql2 = "SELECT * FROM clients WHERE email = '$email'";
    $result2 = $conn2->query($sql2);

    if ($result1->num_rows > 0 || $result2->num_rows > 0) {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32));

        // Store the token in the first database (signup_staff)
        if ($result1->num_rows > 0) {
            $sql1 = "UPDATE doctors SET reset_token = '$token' WHERE email = '$email'";
            if ($conn1->query($sql1) === TRUE) {
                echo "Password reset instructions sent to your email.";
                // Send password reset email to the user
                if (!sendPasswordResetEmail($email, $token)) {
                    echo "Failed to send password reset instructions. Please try again later.";
                }
            } else {
                echo "Error updating reset token in first database: " . $conn1->error;
            }
        }
        // Store the token in the second database (signup_clients)
        else {
            $sql2 = "UPDATE clients SET reset_token = '$token' WHERE email = '$email'";
            if ($conn2->query($sql2) === TRUE) {
                echo "Password reset instructions sent to your email.";
                // Send password reset email to the user
                if (!sendPasswordResetEmail($email, $token)) {
                    echo "Failed to send password reset instructions. Please try again later.";
                }
            } else {
                echo "Error updating reset token in second database: " . $conn2->error;
            }
        }
    } else {
        echo "Email not found in our records.";
    }

    // Close connections
    $conn1->close();
    $conn2->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        input[type=email] {
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
    <h2>Forgot Your Password ? </h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
