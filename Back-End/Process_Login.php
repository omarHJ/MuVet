<?php
        session_start();
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname1 = "signup_clients";
        $dbname2 = "signup_staff";


        // Create connection
        $conn1 = new mysqli($servername, $username, $password, $dbname1);
        $conn2 = new mysqli($servername, $username, $password, $dbname2);


        // Check connection
        if ($conn1->connect_error || $conn2->connect_error) {
            die("Connection to database failed: " . ($conn1->connect_error ? $conn1->connect_error : $conn2->connect_error));
        }    

        // Login form submission
        if (isset($_POST['login'])) {
            // Get form data
            $email = $_POST['email'];
            $emp_id = $_POST['Emp_ID'];
            $password = $_POST['password'];

            // Query the database to check if the user exists
            $sql1 = "SELECT * FROM clients WHERE email = '$email'";
            $result1 = $conn1->query($sql1);

            $sql2 = "SELECT * FROM doctors WHERE Emp_ID = '$emp_id' AND email = '$email'";
            $result2 = $conn2->query($sql2);

            if ($result1->num_rows > 0) {
                // User found, check the password
                $row = $result1->fetch_assoc();
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    // Login successful
                    $_SESSION['username'] = $row['full_name'];
                    // Get the current URL
                    $currentUrl = $_SERVER['REQUEST_URI'];
                    // Extract the language from the current URL
                    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
                    // Redirect to the client-app.php page with the language parameter
                    header("Location: http://localhost/MuVet/client-app.php?lang=$lang");
                    exit();
                } else {
                    // Invalid password, display an error message
                    echo '<script>alert("Invalid password");</script>';
                    /*echo "$password";
                    echo "$hashed_password";*/
                }
            } 
            elseif ($result2->num_rows > 0) {

                // User found, check the password
                $row = $result2->fetch_assoc();
                $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    // Login successful
                    $_SESSION['username'] = $row['full_name'];
                    // Get the current URL
                    $currentUrl = $_SERVER['REQUEST_URI'];
                    // Extract the language from the current URL
                    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
                    // Redirect to the client-app.php page with the language parameter
                    header("Location: http://localhost/MuVet/doctor%20dashbord.php?lang=$lang");
                    exit();
                } else {
                    // Invalid password, display an error message
                    echo '<script>alert("Invalid password");</script>';
                }
            } 
            else {
                // User not found, display an error message
                echo '<script>alert("Invalid password or email");</script>';
            }
        }

        // Close the database connection
        $conn1->close();
        $conn2->close();
        
        ob_end_flush();
    ?>
