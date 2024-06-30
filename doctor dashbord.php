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
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "signup_staff";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape user inputs for security
        $full_name = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $password = $conn->real_escape_string($_POST['new_password']);

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update query
        $sql = "UPDATE doctors SET full_name='$full_name', email='$email', phone_number='$phone_number', password='$hashed_password' WHERE full_name='{$_SESSION['username']}'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $full_name;
            echo '<script>alert("Record updated successfully");</script>';
        } else {
            echo "<script>alert('Error updating record ! " . $conn->error . "');</script>";
        }
        $conn->close();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles/doctor-dashboard.css">
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
    <br>
    <h2 id="profil">Profile</h2>
        <div class="div-cont">
            <div style=" display: flex; justify-content: center;">
                <div style="width:30%; flex-direction:column; text-align:center">
                    <div>
                    <?php
                    // Database connection credentials
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "signup_staff";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Retrieve image data from the database
                    $sql = "SELECT imgs FROM doctors WHERE full_name = '{$_SESSION['username']}'";
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
                        echo '<p> No Pic </p>';
                    }
                    ?>
                    </div>
                    <div>
                        <form id="uploadForm" enctype="multipart/form-data" method="post">
                            <input type="file" id="fileInput" name="image" style="display: none;" accept="image/*">
                            <button type="button" id="uploadButton" style="cursor:pointer;background-color: rgb(61, 135, 196); color:white; padding: 2% 3%; border-radius:10px; border: 1px gray; margin-top: 2%; font-weight:bold">Change Picture</button>
                        </form>
                    </div>
                    <script>
                        document.getElementById('fileInput').addEventListener('change', function() {
                            uploadImage();
                        });

                        document.getElementById('uploadButton').addEventListener('click', function() {
                            document.getElementById('fileInput').click();
                        });

                        function uploadImage() {
                            var formData = new FormData();
                            var fileInput = document.getElementById('fileInput');
                            formData.append('image', fileInput.files[0]);

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'Back-end/upload.php', true);

                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    alert('Image updated successfully.');
                                    location.reload();//Reload the page in order to show the new profile photo
                                } else {
                                    alert('Error occurred: ' + xhr.responseText);
                                }
                            };

                            xhr.send(formData);
                        }
                    </script>
                </div>
                
                <p style=" display: flex; justify-content: center; flex-direction: row">
                    <p style="margin-right: 3%; margin-top: 2%">
                    <span id="empID"> Emp_ID : </span><br> 
                    <span id="fullname"> Name :</span> <br>
                    <span id="email"> Email : </span><br>
                    <span id="phone"> Phone : </span><br>
                    </p>
                    <p>
                    <?php 
                        // Fetch and display existing animal records
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "signup_staff";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT Emp_ID, email, full_name, phone_number FROM doctors where full_name = '{$_SESSION['username']}'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<div class='div-con' style='margin-top: 2%'";
                            echo "<ul>";
                            while($row = $result->fetch_assoc()) {
                                echo "<ul>" . $row["Emp_ID"] . "</ul>";
                                echo "<ul>" . $row["full_name"] . "</ul>";
                                echo "<ul>" . $row["email"] . "</ul>";
                                echo "<ul>" . $row["phone_number"] . "</ul>";
                            }
                            echo "</ul>";
                        }
                        ?>
                    </p>
                </p>
            </div>
        </div>
    </main>
        <br>
    <main>
        <h2 id="appoint2">Appointment</h2>
        <div class='div-cont'>
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

            $sql = "SELECT * FROM booked_appointments";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th id='date'>Date</th><th id='time'>Time</th><th id='name'>Case ID</th><th id='clients2'>Client</th></tr>";
                while($row = $result->fetch_assoc()) {
                    
                    echo "<tr>";
                    echo "<td>" . $row["app_date"] . "</td>";
                    echo "<td>" . $row["app_time"] . "</td>";
                    echo "<td>" . $row["booked_AppointmentID"] . "</td>";
                    echo "<td>" . $row["client"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No booked apointements found.";
            }
        ?>
        </div>
    </main>
        <br>
    <main>
        <h2 id="clients">Clients</h2>
            <div class="div-cont">
            <?php 
                // Fetch and display booked appointments
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "signup_clients";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM clients";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th id='owner name'>Name</th><th id='Email'>Email</th><th id='phone2'>Phone</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        
                        echo "<tr>";
                        echo "<td>" . $row["full_name"] . "</td>";
                        echo "<td><a href=\"mailto:" . $row["email"] . "\" title=\"Send email\">" . $row["email"] . "</a></td>";
                        echo "<td>" . $row["phone_number"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No booked apointements found.";
                }
            ?> 
            </div>
    </main>
        <br>
    <main>
        <h2 id="setting3">Setting</h2>
            <form method="post">
            <div class="div-cont">
                <div class="flex-div"  style="transform: translateX(-8px)">
                    <p>
                        <label for="username"> </label>
                        <input type="text" placeholder="Full Name" id="username" name="username" required><br><br>
                    </p>
                    <p>
                        <label for="email"> </label>
                        <input type="email" placeholder="Email" id="email" name="email" required><br><br>
                    </p>
                    <p>  
                        <label for="Phone"> </label>
                        <input type="tel" placeholder="Phone Number" id="Phone" name="phone_number" required><br><br>
                    </p>
                    <p>
                        <label for="password"> </label>
                        <input type="password" placeholder="Password" id="password" name="new_password" required><br><br>
                    </p>
                    <p>
                        <label for="confirm_password"> </label>
                        <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required><br><br>
                        
                        <button id="btn2" type="submit" value="Submit" style=" background-color: rgb(61, 135, 196); color: white; padding: 8%;
                        border: none; padding-left: 13%; padding-right: 13%; border-radius: 15px; ">Save changes</button>
                    </p>
                </div>
            </div>
        </form>
    </main>

    <script>
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