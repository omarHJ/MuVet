<?php
    session_start();
    // Check if the logout button is clicked
    if(isset($_POST['logout'])) {
        // Destroy the session
        session_destroy();
        // Redirect to the login page
        header("Location: Staff%20login.html");
        exit; // Ensure that no more code is executed after the redirect
    }
    
    //adding an appointment
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "appointments";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve form data
        $date = $conn->real_escape_string($_POST['Date']);
        $time = $conn->real_escape_string($_POST['time']);
        $app_id = $conn->real_escape_string($_POST['Appointment_ID']);  

        // Insert data into database
        $sql = "INSERT INTO available_appointments ( app_date, app_time, AppointmentID) 
                VALUES ('$date', '$time', '$app_id')";

        if ($conn->query($sql) === TRUE) {
            //$_SESSION['success_message'] = "Record inserted successfully!";
            echo '<script>alert("Appointment inserted successfully!");</script>';
        } else {
            echo "<script>alert('Error inserting appointment ! " . $conn->error . "');</script>";

        }        
    }

    // Process delete action
    if (isset($_POST['delete_appointment'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "appointments";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve animal ID to delete
        $appointments_id_to_delete = $conn->real_escape_string($_POST['delete_appointment']);
        $delete_sql = "DELETE FROM available_appointments WHERE AppointmentID = '$appointments_id_to_delete'";
        if ($conn->query($delete_sql) === TRUE) {
            echo '<script>alert("Record deleted successfully!");</script>';
            // You might want to refresh the page here to reflect the changes
            // header("Refresh:0");
        } else {
            echo "<script>alert('Error inserting deleting animal ! " . $conn->error . "');</script>";

        }
    }

    // Process edit action
    if (isset($_POST['edit_appointment'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "appointments";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Retrieve animal ID to delete
        $appointments_id_to_edit = $conn->real_escape_string($_POST['edit_appointment']);
        // Prepare and execute the SQL query
        $edit_sql = "SELECT * FROM available_appointments WHERE AppointmentID = '$appointments_id_to_edit'";
        $edit_result = mysqli_query($conn, $edit_sql);
        
        // Check if the query executed successfully and fetched any rows
        if($edit_result && mysqli_num_rows($edit_result) > 0) {
            $row = mysqli_fetch_assoc($edit_result);
            // Assign values from the fetched row to variables
            $appointment_id = $row['AppointmentID'];
            $date = $row['app_date'];
            $time = $row['app_time'];
        }
    
        deleteAppointment($conn, $appointments_id_to_edit);
    }
    // Define a function to handle delete action in the edit
    function deleteAppointment($conn, $app_id) {
        $delete_sql = "DELETE FROM available_appointments WHERE AppointmentID = '$app_id'";
        if ($conn->query($delete_sql) === TRUE) {
            //echo '<script>alert("Record deleted successfully!");</script>';
            // You might want to refresh the page here to reflect the changes
            // header("Refresh:0");
        } else {
            echo "<script>alert('Error inserting deleting animal ! " . $conn->error . "');</script>";
        }
    }
?>
<html>

<head>
    <script>
        // Function to fetch and load language translations
        function loadTranslations(language) {
            fetch(languageFiles[language])
                .then(response => response.json())
                .then(data => {
                    // Update text content based on translations
                    Object.keys(data).forEach(key => {
                        const element = document.getElementById(key);
                        if (element) {
                            element.textContent = data[key];
                        }
                    });
                    // Update URL with new language parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('lang', language);
                    const newUrl = window.location.pathname + '?' + urlParams.toString();
                    window.history.replaceState({}, '', newUrl);

                    <?php    
                    $currentUrl = $_SERVER['REQUEST_URI'];

                    // Retrieve the language parameter from the URL
                    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Default to 'en' if language parameter is not set
                    ?>
                })
                .catch(error => console.error('Error loading translations:', error));
        }
        window.addEventListener('DOMContentLoaded', (event) => {
      const urlParams = new URLSearchParams(window.location.search);
      const clickParam = urlParams.get('click');
      
      if (clickParam === 'moon') {
        const moonElement = document.getElementById('moon');
        moonElement.click();
      }
    });
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="TE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles/doctor-app.css">
</head>

<body class="dark">
    
<script src='JavaScript/Dark-mode.js'></script>
    <header>
        <section class="header-title-line">
            <img  id="img1" src="imgs/mu-vet-high-resolution-logo-transparent.png">
            <button class="menu-button"><div class="menu-icon"></div>
            </button>
        </section>
        <div style="text-align:right; margin-right:7px;">
            <span class="emoji" id="moon">🌙</span>
            <span class="emoji" id="sun">☀️</span>
        </div>
            <nav>
            <ul>
                <li style="transform: translateX(7px);">
                    <select style="background-color: transparent; color: blue; border: none; font-family: monospace;  font-weight: bolder; font-size: large" id="language-select">
                        <option style="background-color: transparent;" value="en">English</option>
                        <option style="background-color: transparent;" value="ar">العربية</option>
                    </select>
                </li>
                <li><a href ='index.html?lang=<?php echo $lang ?>' class="nav-link" id="home"> Home </a></li>
                <li><a href='doctor%20dashbord.php?lang=<?php echo $lang ?>' class="nav-link" id="dashboard"> Dashboard </a></li>
                <li><a href='staff%20app.php?lang=<?php echo $lang ?>' class="nav-link" id="appoint"> Appointment </a></li>
                <li><a href='staff%20cases.php?lang=<?php echo $lang ?>' class="nav-link" id="cases"> Cases</a></li>
                <li style="text-align: center"><?php echo $_SESSION['username']; ?></li>
                <form method="post">
                    <li style="text-align: center;">
                        <button type="submit" name="logout" id="logout" style="background-color: #0074D9; color: white; padding: 7px; border: none; padding-left: 4%; padding-right: 4%; border-radius: 10px; cursor:pointer">
                            Log Out
                        </button>
                    </li>
                </form>
            </ul>
        </nav>

    </header>

    <main>
        <div class="container">
            <h2 style="padding: 10px; margin-top: 20px; color: rgb(33, 122, 138);" id="appoint2">Appointment</h2>
            <section class="appointment-section">
                <form class="appointment-form" method="post">
                    <div class="form-row">
                        <div>
                            <label id="date" for="Date">Date:</label>
                            <input type="date" id="Date" name="Date" value="<?php echo isset($date) ? $date : ''; ?>" required>
                        </div>
                        <div>
                            <label id="time" for="time">Time:</label>
                            <input type="time" id="time" name="time" value="<?php echo isset($time) ? $time : ''; ?>" required>
                        </div>
                        <div>
                            <label id="appointID" for="Appointment_ID">Appointment ID:</label>
                            <input type="number" id="Appointment_ID" name="Appointment_ID" value="<?php echo isset($appointment_id) ? $appointment_id : ''; ?>" required>
                        </div>
                    </div>
                    <button name="add" style="margin-bottom: 2%;" id="addButton">Add Appointment</button>
                </form>
            </section>
            <main class="appointment-section">
                <?php
                    echo"<table style= 'text-align: center'>";
                        echo "<tr><th style='border-top-left-radius: 10px; width: 25%;' id='date2'>Date</th><th style='width: 25%;' id='time02'>Time</th><th style='width: 25%;' id='appointID2'>Appointment ID </th><th style='width: 25%;'> </th> </tr>";
                        
                            // Fetch and display booked appointments
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "appointments";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            

                            $sql = "SELECT * FROM available_appointments";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                               
                                while($row = $result->fetch_assoc()) {
                                    
                                    echo "<tr>";
                                    echo "<td>" . $row["app_date"] . "</td>";
                                    echo "<td>" . $row["app_time"] . "</td>";
                                    echo "<td>" . $row["AppointmentID"] . "</td>";
                                    echo "<td style='display: flex; justify-content: space-between;'>
                                    <form method='post' style='flex: 1; margin: 0 5px;'> <!-- Adjusted styles -->
                                        <input type='hidden' name='edit_appointment' value='" . $row['AppointmentID'] . "'>
                                        <button style='background-color: transparent' title=\"Edit Case\" type='submit' name='edit' onclick='return confirmEditAppointment()'><img style='width:40%' src='imgs/tmp_81038e2c-3fb2-4e69-8089-e724c0c05cfc.png'></button>
                                        </form>
                                    <form method='post' style='flex: 1; margin: 0 5px;'> <!-- Adjusted styles -->
                                        <input type='hidden' name='delete_appointment' value='" . $row['AppointmentID'] . "'>
                                        <button style='width: fit-content; background-color: transparent' title=\"Delete\" type='submit' name='delete' onclick='return confirmDeleteAppointment()'><img style='width:37%' src='imgs/tmp_8b65d7ed-3d4d-4167-bb46-e4add1e8d420.png'></button>
                                    </form>
                                </td>"; 
                                    echo "</tr>";
                                }
                            } else {
                                echo "Sorry, No available appointemnts.";
                            }
                ?>
            </main>
        </div>
    </main>                          
    <script>
        function confirmEditAppointment() {
            return confirm("Are you sure you want to Edit this appointment ?");
        }
        function confirmDeleteAppointment() {   
            return confirm("Are you sure you want to Delete this appointment ?");
        }
        const languageFiles = {
            en: 'en.json',
            ar: 'ar.json'
        };

        // Initialize language (with fallback to 'en')
        function initializeLanguage() {
            const urlParams = new URLSearchParams(window.location.search);
            const langParam = urlParams.get('lang');
            const userLang = langParam || navigator.language.split('-')[0] || 'en'; // Fallback to browser language or 'en'
            loadTranslations(userLang);

            // Update language select
            const selectElement = document.getElementById('language-select');
            if (selectElement) {
                selectElement.value = userLang; // Set selected language
                selectElement.addEventListener('change', () => {
                    const newLang = selectElement.value;
                    if (newLang !== userLang) {
                        // Update URL with new language parameter
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('lang', newLang);
                        const newUrl = window.location.pathname + '?' + urlParams.toString();
                        window.history.replaceState({}, '', newUrl);
                        location.reload(); // Reload the page
                    }
                });
            }
        }
        
        // Initial load
        window.addEventListener('load', initializeLanguage);
        


        // Select the elements
        const moon = document.getElementById('moon');
        const sun = document.getElementById('sun');

        // Variable to store the selected ID, defaulting to "sun"
        let selectedID = 'sun';

        // Function to handle click event
        function handleClick(event) {
            // Set the selectedID to the ID of the clicked element
            selectedID = event.target.id;
            updateLink();
        }

        // Function to update the link based on the selected element
        function updateLink() {
            // Get the current URL
            let currentUrl = new URL(window.location.href);

            // Append the query parameters based on the selected element
            let queryParams = '';
            if (selectedID === 'moon') {
                queryParams = 'click=moon&lang=<?php echo $lang ?>';
            } else if (selectedID === 'sun') {
                queryParams = 'click=sun&lang=<?php echo $lang ?>';
            }

            // Update the URL
            currentUrl.search = queryParams;

            // Store the selected state in session storage
            sessionStorage.setItem('selectedClick', selectedID);

            // Update the URL
            window.history.replaceState({}, '', currentUrl.toString());
        }

        // Function to retrieve and set the selected state from session storage
        function setSelectedFromStorage() {
            const storedSelectedID = sessionStorage.getItem('selectedClick');
            if (storedSelectedID) {
                selectedID = storedSelectedID;
            }
        }

        // Call the function to set the selected state from session storage
        setSelectedFromStorage();

        // Add event listeners to the elements
        moon.addEventListener('click', handleClick);
        sun.addEventListener('click', handleClick);

        // Update the link initially (default: sun)
        updateLink();

        window.onload = function() {
            if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
                // If not logged in, redirect to the login page
                window.location.replace("Staff-login.php");
            }
        };

        // Prevent the user from using the back button to return to the client-app.php page
        window.onpageshow = function(event) {
            if (event.persisted) {
                // If the page is persisted in the cache (e.g., due to back/forward navigation),
                // redirect the user to the login page
                window.location.replace("Staff-login.php");
            }
        };

        window.onload = function() {
            if (performance.navigation.type === 2) { // The page was accessed by navigating into the history
                window.location.replace("Staff-login.php");
            }
        };

    </script>
</body>
</html>