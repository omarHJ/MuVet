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

    // Process delete action
    if (isset($_POST['delete'])) {
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
        $case_id_to_delete = $conn->real_escape_string($_POST['CaseID']);
        $delete_sql = "DELETE FROM my_cases WHERE CaseID = '$case_id_to_delete'";
        if ($conn->query($delete_sql) === TRUE) {
            echo '<script>alert("Record deleted successfully!");</script>';
            // You might want to refresh the page here to reflect the changes
            // header("Refresh:0");
        } else {
            echo "<script>alert('Error deleting animal ! " . $conn->error . "');</script>";
        }
    }

    // Process edit action
    if (isset($_POST['edit'])) {
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
        $case_id_to_edit = $conn->real_escape_string($_POST['CaseID']);
        // Prepare and execute the SQL query
        $edit_sql = "SELECT * FROM my_cases WHERE CaseID = '$case_id_to_edit'";
        $edit_result = mysqli_query($conn, $edit_sql);
        
        // Check if the query executed successfully and fetched any rows
        if($edit_result && mysqli_num_rows($edit_result) > 0) {
            $row = mysqli_fetch_assoc($edit_result);
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

        deleteCase($conn, $case_id_to_edit);
    }
    // Define a function to handle deleteCase action
    function deleteCase($conn, $case_id) {
        $delete_sql = "DELETE FROM my_cases WHERE CaseID = '$case_id'";
        if ($conn->query($delete_sql) === TRUE) {
            //echo '<script>alert("Record deleted successfully!");</script>';
            // You might want to refresh the page here to reflect the changes
            // header("Refresh:0");
        } else {
            echo "<script>alert('Error inserting deleting animal ! " . $conn->error . "');</script>";
        }
    }

    //adding a case
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
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
    
        // Retrieve form data
        $case_id = $conn->real_escape_string($_POST['Case_ID']);
        $animal_id = $conn->real_escape_string($_POST['Animal_ID']);
        $birth_date = $conn->real_escape_string($_POST['Birth_date']);
        $type = $conn->real_escape_string($_POST['Type']);
        $animal_name = $conn->real_escape_string($_POST['animal_name']);
        $client_username = $conn->real_escape_string($_POST['owner_name']);
        $blood_test = $conn->real_escape_string($_POST['Blood_Test']);
        $treatment = $conn->real_escape_string($_POST['Treatment']);
        $description= $conn->real_escape_string($_POST['Description']);

        $sql ="INSERT INTO my_cases (CaseID, AnimalID, BirthDate, Species, animalName, OwnerName, BloodTestResult, Treatment, caseDescription) 
        VALUES ('$case_id', '$animal_id', '$birth_date', '$type', '$animal_name', '$client_username', '$blood_test', '$treatment', '$description');";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Record inserted successfully!");</script>';
        } else {
            echo "<script>alert('Error inserting record ! " . $conn->error . "');</script>";
        }        
    }
?>
<html>

<head>
    <script>
        // Check if the user is not logged in when the page loads
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
    <link rel="stylesheet" type="text/css" href="Styles/doctor-cases.css">
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
                
                <li><a href='index.html?lang=<?php echo $lang ?>' class="nav-link" id=home> Home </a></li>
                <li><a href='doctor%20dashbord.php?lang=<?php echo $lang ?>' class="nav-link" id="dashboard"> Dashboard </a></li>
                <li><a href='staff%20app.php?lang=<?php echo $lang ?>' class="nav-link" id="appoint"> Appointment </a></li>
                <li><a href='staff%20cases.php?lang=<?php echo $lang ?>' class="nav-link" id="cases2"> Cases</a></li>
                <li style="text-align: center"><?php echo $_SESSION['username']; ?></li>
                <form method="post">
                    <li style="text-align: center;">
                        <button type="submit" name="logout" id="logout" style="background-color: #0074D9; color: white; padding: 7px; border: none; padding-left: 4%; padding-right: 4%; border-radius: 10px;">
                            Log Out
                        </button>
                    </li>
                </form>
            </ul>
        </nav>

    </header>

    <main>
        <h3 style="margin-left: 2%; color: rgb(33, 122, 138);" id="cases"> Cases </h3>
        <br>
        <div class="div-con">
            <form id="settings-form" style="display: flex; flex-direction: column; align-items: flex-start;" method="post">
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="name" for="case id">Case ID</label>
                    <input type="number" id="name" name="Case_ID" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $case_id : ''; ?>" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="animal id" for="animal id"> Animal ID </label>
                    <input type="number" id="animal id" name="Animal_ID" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $animal_id : ''; ?>" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="birth date" for="birth date">Birth Date</label>
                    <input type="date" id="birth date" name="Birth_date" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $birth_date : ''; ?>" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="type" for="type">Type</label>
                    <input type="text" id="type" name="Type" style="width: 48%; margin-right: 4%;" value="<?php echo isset($case_id) ? $type : ''; ?>" required>
                </div>
                <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                    <label id="animal_name" for="name">Name</label>
                    <input type="text" id="name" name="animal_name" style="width: 48%;  margin-right: 4%;" value="<?php echo isset($case_id) ? $animal_name : ''; ?>" required>
                </div>
                <div style="display: flex; width: 100%;justify-content: space-between; margin-bottom: 10px;">
                    <label id="owner name" for="owner name">Owner Name</label>
                    <input type="text" id="owner name" name="owner_name" style="width: 48%;  margin-right: 4%;" value="<?php echo isset($case_id) ? $client_username : ''; ?>" required>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Blood Test" for="Blood Test" style="margin-top: 2.5%;">Blood Test Result</label>
                    <textarea type="text" id="Blood Test" name="Blood_Test"
                        style="width: 73%; margin-left: 6%;"> <?php echo isset($case_id) ? $blood_test : ''; ?> </textarea>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Treatment" for="Treatment" style="margin-top: 2.5%;"> Treatment </label>
                    <textarea type="text" id="Treatment" name="Treatment"
                        style="width: 73%; margin-left: 13%;"> <?php echo isset($case_id) ? $treatment : ''; ?> </textarea>
                </div>
                <div style="display: flex; width: 100%; margin-bottom: 10px;">
                    <label id="Description" for="Description" style="margin-top: 2.5%;"> Description </label>
                    <textarea type="text" id="Description" name="Description"
                        style="width: 73%; margin-left: 12%;"> <?php echo isset($case_id) ? $description : ''; ?> </textarea>
                </div>
                <br>
                <div style="text-align: right; width: 100%; ">
                    <button name="add" id="addButton"
                        style="background-color: #0074D9; color: white; padding: 7px; border: none;  margin-right: 8%; padding-left: 3%; padding-right: 3%; border-radius: 10px;">
                        Add
                    </button>
                </div>
            </form>
        </div>
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

            $sql = "SELECT AnimalID, animalName, CaseID FROM my_cases";
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
                    echo "<td style='display: flex; flex-direction: row; width: 100%'> 
                        <form style='width: 50%; margin-right: 10%' method='post' onsubmit='return confirmEdit();'>
                            <input type='hidden' name='CaseID' value='" . $row["CaseID"] . "'>
                            <button style='background-color: transparent' title=\"Edit Case\" type='submit' name='edit'><img style='width:40%' src='imgs/tmp_81038e2c-3fb2-4e69-8089-e724c0c05cfc.png'></button>
                        </form>
                        <form style='width: 50%' method='post' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='CaseID' value='" . $row["CaseID"] . "'>
                            <button style='width: fit-content; background-color: transparent' title=\"Delete\" type='submit' name='delete'><img style='width:37%' src='imgs/tmp_8b65d7ed-3d4d-4167-bb46-e4add1e8d420.png'></button>
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
        <br>
        <br>
    </main>

    <script>
        function confirmEdit() {
            return confirm("Are you sure you want to Edit this case record?");
        }
        function confirmDelete() {
            return confirm("Are you sure you want to Delete this case record?");
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