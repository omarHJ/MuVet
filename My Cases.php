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

    // Process Display action
    if (isset($_POST['Display'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cases";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve animal ID to delete
        $case_id_to_display = $conn->real_escape_string($_POST['CaseID']);
        // Prepare and execute the SQL query
        $display_sql = "SELECT * FROM my_cases WHERE CaseID = '$case_id_to_display'";
        $display_result = mysqli_query($conn, $display_sql);
        
        // Check if the query executed successfully and fetched any rows
        if($display_result && mysqli_num_rows($display_result) > 0) {
            $row = mysqli_fetch_assoc($display_result);
            // Assign values from the fetched row to variables
            $case_id = $row['CaseID'];
            $animal_name = $row['animalName'];
            $birth_date = $row['BirthDate'];
            $type = $row['Species'];
            $animal_id = $row['AnimalID'];
            $client_username = $row['OwnerName'];
            $blood_test = $row['BloodTestResult'];
            $treatment = $row['Treatment'];
            $description= $row['caseDescription'];
        }
    }
?>
<!DOCTYPE html>

<head>
<title> My Cases </title>
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
                    $lang = isset($_GET['lang']) ? $_GET['lang'] : ''; // Default to 'en' if language parameter is not set

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
    <link rel="stylesheet" type="text/css" href="Styles/Client-cases.css">
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
                    <a  href="client-app.php?lang=<?php echo $lang ?>" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/schedule.png">
                        <span id="appoint" class="link-text"> Appointments </span>
                    </a>
                    <a href="#" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/first-aid-kit.png">
                        <span id="cases" class="link-text"> Cases </span>
                    </a>
                </p>
                <p class="flexy">
                    <a  href="My%20Animal.php?lang=<?php echo $lang ?>" class="nav-link">
                        <img id="id2" style="width: 15%; margin-left: 5%; margin-right: 5%;" src="imgs/pet-house.png">
                        <span id="myanimal" class="link-text"> My Animals </span>
                    </a>
                    <a  href="setting.php?lang=<?php echo $lang ?>" class="nav-link ">
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
        <h3 id="cases2"> My Cases </h3>
        <br>
        <?php 
            // Fetch and display existing animal records
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "cases";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $client_username = $_SESSION['username'];

            $sql = "SELECT AnimalID, animalName, CaseID FROM my_cases WHERE OwnerName = '$client_username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='div-con'>";
                echo "<table>";
                echo "<tr><th id='animal_id'>Animal ID</th><th id='animal name'>Animal Name</th><th id='case id'>Case ID</th><th>   </th></tr>";
                while($row = $result->fetch_assoc()) {
                    
                    echo "<tr>";
                    echo "<td>" . $row["AnimalID"] . "</td>";
                    echo "<td>" . $row["animalName"] . "</td>";
                    echo "<td>" . $row["CaseID"] . "</td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='CaseID' value='" . $row["CaseID"] . "'>
                            <button title=\"Display Case\" type='submit' name='Display' id='display'>Display</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No cases found.";
            }
            echo "</div>";
        ?>
        <br><br>
        <div class="div-con">
            <form id="settings-form" style="display: flex; flex-direction: column; align-items: flex-start;" method="post">
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label  id="name" for="case id">Case ID</label>
                    <input type="number" id="name" name="Case_ID" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $case_id : ''; ?>" readonly>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="animal id" for="animal id"> Animal ID </label>
                    <input type="number" id="animal id" name="Animal_ID" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $animal_id : ''; ?>" readonly>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="birth date" for="birth date">Birth Date</label>
                    <input type="date" id="birth date" name="Birth_date" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $birth_date : ''; ?>" readonly>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="type" for="type">Type</label>
                    <input type="text" id="type" name="Type" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $type : ''; ?>" readonly>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="animal_name" for="name">Name</label>
                    <input type="text" id="animal_name" name="animal_name" style="width: 48%;  margin-right: 4%;" value="<?php echo isset($case_id) ? $animal_name : ''; ?>" readonly>
                </div>
                <div style="display: flex; width: 100%;justify-content: space-between; margin-bottom: 10px;">
                    <label id="owner name" for="owner name">Owner Name</label>
                    <input type="text" id="owner name" name="owner_name" style="width: 48%;  margin-right: 4%; " value="<?php echo $_SESSION['username']; ?>" readonly>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Blood Test" for="Blood Test" style="margin-top: 2.5%;">Blood Test Result</label>
                    <textarea type="text" id="Blood Test" name="Blood_Test"
                        style="width: 72%; margin-left: 5%;" readonly> <?php echo isset($case_id) ? $blood_test : ''; ?> </textarea>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Treatment" for="Treatment" style="margin-top: 2.5%;"> Treatment </label>
                    <textarea type="text" id="Treatment" name="Treatment"
                        style="width: 72.25%; margin-left: 12.5%;" readonly> <?php echo isset($case_id) ? $treatment : ''; ?> </textarea>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Description" for="Description" style="margin-top: 2.5%;"> Description </label>
                    <textarea type="text" id="Description" name="Description"
                        style="width: 72.45%; margin-left: 11.3%;" readonly> <?php echo isset($case_id) ? $description : ''; ?> </textarea>
                </div>
                
            </form>
        </div>
    </main>
    
    <script>
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