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
    // Check if form is submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "signup_clients";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $conn->real_escape_string($_POST['new-password']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update query
    $sql = "UPDATE clients SET full_name='$full_name', cli_address='$address', email='$email', phone_number='$phone_number', cli_password='$hashed_password' WHERE full_name='{$_SESSION['username']}'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $full_name;
        echo '<script>alert("Record updated successfully");</script>';
    } else {
        echo "<script>alert('Error inserting updating record ! " . $conn->error . "');</script>";
    }

    $conn->close();
    
 }


?>
<!DOCTYPE html>

<head>
    <title> Setting </title>
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
    <link rel="stylesheet" type="text/css" href="Styles/Client-setting.css">
</head>

<body class="dark">
<script src='JavaScript/Dark-mode.js'></script>
    <div id="top_div" class="upper-edge-container">
        <p id="pic1" style="margin-top: 15px;width: 48%;">
            <a><img style="height: 75%; width: 45%;" src="imgs/mu-vet-high-resolution-logo-transparent.png"></a>
        </p>
        <p id="text" style="margin-right: 15px; font-family: monospace; font-weight: bold">
            <a id="home" onclick="window.location.href ='index.html'" style="cursor: pointer; margin-left: 2.5%">Home </a><span id="contactButton" style="cursor:pointer; text-decoration: none; margin-right: 2%; margin-left: 2.5%"> Contact </span>
            <select style="background-color: transparent; color: blue; border: none; font-family: monospace;  font-weight: bold; font-size: large" id="language-select">
                <option style="background-color: transparent;" value="en">English</option>
                <option style="background-color: transparent;" value="ar">العربية</option>
            </select>
            <span class="emoji" id="moon">🌙</span> <span class="emoji" id="sun">☀️</span>
        </p>
    </div>
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p style="color: black">Clinic Land Line  1 :  06533518  <br> Clinic Land Line  2 :  06533520</p>
        </div>
    </div>
    <nav class="navbar ">
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
                    <a href="client-app.php?lang=<?php echo $lang ?>" class="nav-link">
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
                    <a href="#" class="nav-link ">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/user.png">
                        <span id="setting" class="link-text"> Setting </span>
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
        <h3 id="setting2"> My Information </h3>
        <br>
        <div class="div-con">
            <div style="display: flex; justify-content: space-between; width: 100%; margin-top: 5px;">
                    <p style="width: 75%">
                        <label id="personalPic" for="personal pic"> Personal Photo </label>
                    </p>
                    <P>
                        <form id="uploadForm" enctype="multipart/form-data" method="post" style="width: 20%">
                            <input type="file" id="fileInput" name="image" style="display: none;" accept="image/*">
                            <button type="button" id="uploadButton" style="cursor:pointer;background-color: #0074D9; color:white;
                             padding: 4% 2%; border-radius:10px; border: 1px gray; font-weight:bold; width: 70%; margin-right: 20%;">Change</button>
                        </form>
                    </p>
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
                                    // Optionally, you can update the page content here if needed.
                                    location.reload();
                                } else {
                                    alert('Error occurred: ' + xhr.responseText);
                                }
                            };

                            xhr.send(formData);
                        }
            </script>
        </div>
        <br>
        <div class="div-con">
            <form id="settings-form" method="post" style="display: flex; flex-direction: column; align-items: flex-start;">
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="fullname" for="name">Name</label>
                    <input type="text" id="name" name="full_name" style="width: 48%; margin-right: 4%;" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="address" for="address"> Address</label>
                    <input type="text" id="address" name="address" style="width: 48%; margin-right: 4%;" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;" required>
                    <label id="email" for="email">Email Address</label>
                    <input type="email" id="email" name="email" style="width: 48%; margin-right: 4%;">
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;" required>
                    <label id="phone" for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone_number" style="width: 48%; margin-right: 4%;">
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;" required>
                    <label id="new-password" for="new-password">New Password</label>
                    <input type="password" id="new-password" name="new-password" style="width: 48%;  margin-right: 4%;" required>
                </div>
                <div style="display: flex; width: 100%;justify-content: space-between; margin-bottom: 10px;">
                    <label id="confirm-password" for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password"
                        style="width: 48%;  margin-right: 4%;">
                </div>
                <br>
                <div style="text-align: right; width: 100%; ">
                    <button type="submit" value="Submit" id="save_button"
                        style=" background-color: #0074D9; color: white; padding: 7px; border: none;  margin-right: 4%; border-radius: 5px;margin-right: 8%; padding-left: 3%; padding-right: 3%;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
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
            console.log('Select element:', selectElement); // Add this line for debugging
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

document.getElementById("password").addEventListener("input", function() {
        var password = this.value;
        var confirmPasswordInput = document.getElementById("confirm_password");
        var confirmPassword = confirmPasswordInput.value;

        if (password !== confirmPassword) {
            confirmPasswordInput.setCustomValidity("Passwords do not match");
        } else {
            confirmPasswordInput.setCustomValidity("");
        }
        });

        document.getElementById("confirm_password").addEventListener("input", function() {
            var confirmPassword = this.value;
            var passwordInput = document.getElementById("password");
            var password = passwordInput.value;

            if (password !== confirmPassword) {
                this.setCustomValidity("Passwords do not match");
            } else {
                this.setCustomValidity("");
            }
        });
        document.getElementById("Phone").addEventListener("input", function() {
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }

        var phoneNumber = this.value.trim();
        var pattern = /^(077|078|079)\d{7}$/; // Regular expression pattern

        if (!pattern.test(phoneNumber)) {
            this.setCustomValidity("Phone number must start with 077, 078, or 079 followed by 7 digits.");
        } else {
            this.setCustomValidity("");
        }
        });
        document.getElementById("password").addEventListener("input", function() {
        var password = this.value.trim();

        // Regular expression pattern
        var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+={}\[\]:;<>,.?\/\\~-]).{8,}$/;

        if (!pattern.test(password)) {
            this.setCustomValidity("Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one digit, and one special character.");
        } else {
            this.setCustomValidity("");
        }
        });


    </script>
    
</body>

</html>