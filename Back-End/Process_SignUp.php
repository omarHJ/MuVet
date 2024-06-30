<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign_up'])) {
        // Database connection parameters for clients table
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "signup_clients";

        // Create connection for clients table
        $conn_clients = new mysqli($servername, $username, $password, $dbname);

        // Check connection for clients table
        if ($conn_clients->connect_error) {
            die("Connection failed: " . $conn_clients->connect_error);
        }

        // Prepare data for insertion into clients table
        $full_name = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['Phone'];
        $address = $_POST['Address'];
        $password = $_POST['password'];

        // Hash the password for clients table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL to insert data into clients table
        $sql_clients = "INSERT INTO clients (full_name, email, phone_number, cli_address, password) VALUES ('$full_name', '$email', '$phone_number', '$address', '$hashed_password')";

        if ($conn_clients->query($sql_clients) === TRUE) {
            echo '<script>
                    alert("You signed up successfully! Click OK to proceed to login.");
                    window.location.href = "client%20login.html";
                  </script>';
            exit;
        } else {
            echo "<script>alert('Error registering clients! " . $conn_clients->error . "');</script>";
        }

        $conn_clients->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign_up'])) {
        // Database connection parameters for doctors table
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "signup_staff";

        // Create connection for doctors table
        $conn_doctors = new mysqli($servername, $username, $password, $dbname);

        // Check connection for doctors table
        if ($conn_doctors->connect_error) {
            die("Connection failed: " . $conn_doctors->connect_error);
        }

        // Prepare variables from POST request for doctors table
        $full_name = $_POST['username'];
        $emp_id = $_POST['Emp_ID'];
        $email = $_POST['email'];
        $phone_number = $_POST['Phone'];
        $password = $_POST['password'];

        // Validate input data for doctors table
        if (empty($full_name) || empty($email) || empty($phone_number) || empty($emp_id) || empty($password)) {
            die("All fields are required for doctors.");
        }

        // Hash the password before storing it in the doctors table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into doctors table
        $sql_doctors = "INSERT INTO doctors (Emp_ID, full_name, email, phone_number, password) VALUES ('$emp_id', '$full_name', '$email', '$phone_number', '$hashed_password')";

        if ($conn_doctors->query($sql_doctors) === TRUE) {
            echo '<script>
                    alert("You signed up successfully! Click OK to proceed to login.");
                    window.location.href = "Doctor%20login.html";
                  </script>';
            exit;
        } else {
            echo "<script>alert('Error registering doctors! " . $conn_doctors->error . "');</script>";

        }

        $conn_doctors->close();
    }
    ob_end_flush();
?>