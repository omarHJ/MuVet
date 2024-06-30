<?php
    session_start();
    // Check if the logout button is clicked
    if(isset($_POST['logout'])) {
        // Destroy the session
        session_destroy();
        // Redirect to the login page
        header("Location: client%20login.html");
        exit; // Ensure that no more code is executed after the redirect
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

        // Retrieve ID to delete
        $appointment_to_delete = $conn->real_escape_string($_POST['delete_appointment']);

        // Retrieve the appointment details before deleting
        $select_sql = "SELECT * FROM booked_appointments WHERE booked_AppointmentID = '$appointment_to_delete'";
        $result = $conn->query($select_sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $date = $row['app_date'];
            $time = $row['app_time'];

            // Retrieve the last AppointmentID and increment it by one
            $last_id_query = "SELECT MAX(AppointmentID) AS last_id FROM available_appointments";
            $last_id_result = mysqli_query($conn, $last_id_query);

            if ($last_id_row = mysqli_fetch_assoc($last_id_result)) {
                $last_id = $last_id_row['last_id'];
                $new_id = $last_id + 1;

                // Delete the appointment
                $delete_sql = "DELETE FROM booked_appointments WHERE booked_AppointmentID = '$appointment_to_delete'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo '<script>alert("Appointment deleted successfully!");</script>';

                    // Insert the appointment into the available_appointments table
                    $insert_sql = "INSERT INTO available_appointments (app_date, app_time, AppointmentID) VALUES ('$date', '$time', '$new_id')";
                    if ($conn->query($insert_sql) === TRUE) {
                        echo '<script>alert("Deleted appointment added back to available appointments!");</script>';
                    } else {
                        echo "<script>alert('Error inserting deleted appointment: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error Deleting ! " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Error retrieving last AppointmentID: " . $conn->error . "');</script>";
            }
        } else {
            echo "";
        }
    }

    // Process book action
    if (isset($_POST['book_appointment'])) {
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

        // Retrieve  ID to delete
        $appointment_to_book = $conn->real_escape_string($_POST['book_appointment']);

        // Retrieve the appointment details before deleting
        $select_sql="SELECT * FROM available_appointments WHERE AppointmentID='$appointment_to_book'";
        $result = $conn->query($select_sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $date = $row['app_date'];
            $time = $row['app_time'];
            
            // Delete the appointment
            $delete_sql = "DELETE FROM available_appointments WHERE AppointmentID = '$appointment_to_book'";
            if ($conn->query($delete_sql) === TRUE) {
                echo '<script>alert("Appointment booked successfully!");</script>';
                
                // Insert the appointment into the appointments table
                $insert_sql="INSERT INTO booked_appointments (app_date, app_time, client) VALUES ('$date', '$time', '{$_SESSION['username']}')";
                if ($conn->query($insert_sql) === TRUE) {
                    echo "";
                } else {
                    echo "<script>alert('Error inserting deleted appointment: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Error Deleted ! " . $conn->error . "');</script>";

            }
        } else {
            echo "";
        }
    }
?>
<!DOCTYPE html>
<head>
    <title> Appointments </title>
    <script>
        //Function to fetch and load language translations
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles/Client-app.css">

</head>

<body class="dark">
    <script src='JavaScript/Dark-mode.js'></script>
    <div id="top_div" class="upper-edge-container ">
        <p id="pic1" style="margin-top: 15px;width: 48%;">
            <a><img style="height: 75%; width: 45%;" src="imgs/mu-vet-high-resolution-logo-transparent.png"></a>
        </p>
        <p id="text" style="margin-right: 15px; font-family: monospace; font-weight: bold">
            <a id="home" onclick="window.location.href ='index.html'" style="cursor: pointer; margin-left: 2.5%"> Home </a><span id="contactButton" style="cursor:pointer; margin-right: 2%; margin-left: 2.5%"> Contact </span>
            <select style="background-color: transparent; color: blue; border: none; font-family: monospace;  font-weight: bold; font-size: large" id="language-select">
                <option style="background-color: transparent;" value="en">English</option>
                <option style="background-color: transparent;" value="ar">العربية</option>
            </select>
            <span class="emoji" id="moon">🌙</span> <span
                                class="emoji" id="sun">☀️</span>
        </p>
    </div>
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p style="color: black">Clinic Land Line  1 :  06533518  <br> Clinic Land Line  2 :  06533520</p>
        </div>
    </div>
    <nav class="navbar">
        <ul class="navbar-nav">
            <div id="user-button">
                <p>
                <?php
                    // Database connection credentials
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "signup_clients";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Retrieve image data from the database
                    $sql = "SELECT imgs FROM clients WHERE full_name = '{$_SESSION['username']}'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $imgData = $row['imgs'];
                        if ($imgData !== NULL) {
                            echo '<img id="personal-pic" src="data:image/jpeg;base64,'.base64_encode($imgData).'" style="width: 30%;">';
                        } else {
                            // Display default image if imgs field is NULL
                            echo '<img id="personal-pic" src="imgs/user_interface.png" style="width: 30%;">';
                        }
                    } else {
                        echo '<p>No Pic </p>';
                    }
                    ?>
                    </p>
                    <p id="user">
                        <?php echo $_SESSION['username']?>
                    </p>
            </div>
            <li id="list" class="nav-item">
                <p class="flexy">
                    <a href="#" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/schedule.png">
                        <span id="appoint" class="link-text"> Appointments </span>
                    </a>
                    <a href="My%20Cases.php?lang=<?php echo $lang ?>" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/first-aid-kit.png">
                        <span id="cases" class="link-text"> Cases </span>
                    </a>
                </p>
                <p class="flexy">
                    <a href="My%20Animal.php?lang=<?php echo $lang ?>" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/pet-house.png">
                        <span id="myanimal" class="link-text"> My Animals </span>
                    </a>
                    <a href="setting.php?lang=<?php echo $lang ?>" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/user.png">
                        <span id="setting" class="link-text">Setting</span>
                    </a>
                </p>
            </li>
        </ul>
        <form method="post">
        <div style="text-align: center">
            <button id="logout" type="submit" name="logout" style="width: 50%; background-color: #0074D9; color: white; padding: 7px; border: none;
                    padding-left: 4%; padding-right: 4%; border-radius: 10px; margin-left: 0px;  margin-top: 15px">Log Out
            </button>
        </div>
        </form>
    </nav>

    <main>
        <h3 id="myApp"> My Appointments </h3>
        <?php 
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

        $sql = "SELECT * FROM booked_appointments where client = '{$_SESSION['username']}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='div-con'>";
            echo "<table>";
            echo "<tr><th id='date'>Date</th><th id='time'>Time</th><th id='name'>Case ID</th><th>   </th></tr>"; // how to add an id for each th ??
            while($row = $result->fetch_assoc()) {
                
                echo "<tr>";
                echo "<td>" . $row["app_date"] . "</td>";
                echo "<td>" . $row["app_time"] . "</td>";
                echo "<td>" . $row["booked_AppointmentID"] . "</td>";
                echo "<td style='width: 30%;'>
                        <form method='post'>
                        <input type='hidden' name='delete_appointment' value='" . $row['booked_AppointmentID'] . "'>
                        <button id='delApp' style='width: 50%; height: fit-content;' type='submit' class='delete-link' onclick='return confirmDelete()'>
                            Cancel Appointment
                        </button>
                        </form>
                    </td>"; 
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No booked apointements found.";
        }
        echo "</div>";

        echo "<br><br>";
        ?>
        <h3 id="avApp">Appointments Available</h3>
        <?php
        $sql = "SELECT * FROM available_appointments";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='div-con'>";
            echo "<table >";
            echo "<tr><th id='date2'>Date</th><th id='time02'>Time</th><th> </th></tr>";
            while($row = $result->fetch_assoc()) {
                
                echo "<tr>";
                echo "<td style='width: 35%;'>" . $row["app_date"] . "</td>";
                echo "<td style='width: 35%;'>" . $row["app_time"] . "</td>";
                echo "<td style='width: 30%;'>
                        <form method='post'>
                        <input type='hidden' name='book_appointment' value='" . $row['AppointmentID'] . "'>
                        <button id='book' style='width: 50%; height: 30px;' type='submit' onclick='return confirmAppointment()'>
                            Book
                        </button>
                        </form>
                    </td>"; 
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Sorry, No available appointemnts.";
        }
        echo "</div>";

        
        ?>
    </main>
    
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to Delete this appointment ?");
    }
    function confirmAppointment() {
        return confirm("Are you sure you want to book this appointment?");
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



        // Get the button
        let mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        }

            
        // Get the modal
        var modal = document.getElementById("contactModal");

        // Get the button that opens the modal
        var btn = document.getElementById("contactButton");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
        window.onload = function() {
            if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
                // If not logged in, redirect to the login page
                window.location.replace("clinet%20login.php");
            }
        };

        // Prevent the user from using the back button to return to the client-app.php page
        window.onpageshow = function(event) {
            if (event.persisted) {
                // If the page is persisted in the cache (e.g., due to back/forward navigation),
                // redirect the user to the login page
                window.location.replace("clinet%20login.php");
            }
        };

        window.onload = function() {
            if (performance.navigation.type === 2) { // The page was accessed by navigating into the history
                window.location.replace("clinet%20login.php");
            }
        };
    </script>
      
</body>

</html>