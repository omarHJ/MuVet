const languageFiles = {
    en: 'en.json',
    ar: 'ar.json'
};

// Function to fetch and load language translations
function loadTranslations(language) {
    // Replace with your fetch logic to load translations from JSON files
    fetch(languageFiles[language])
        .then(response => response.json())
        .then(data => {
            // Update UI with translations
            Object.keys(data).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = data[key];
                }
            });
        })
        .catch(error => console.error('Error loading translations:', error));
}

// Function to initialize language based on URL parameter or default to 'en'
function initializeLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const langParam = urlParams.get('lang');
    const userLang = langParam || localStorage.getItem('lang') || 'en'; // Default to stored language or 'en'
    loadTranslations(userLang);

    // Update language select dropdown
    const selectElement = document.getElementById('language-select');
    if (selectElement) {
        selectElement.value = userLang; // Set selected language in dropdown

        // Event listener for language change
        selectElement.addEventListener('change', () => {
            const newLang = selectElement.value;
            if (newLang !== userLang) {
                // Update URL with new language parameter
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('lang', newLang);
                const newUrl = window.location.pathname + '?' + urlParams.toString();
                window.history.replaceState({}, '', newUrl);

                // Store selected language in localStorage
                localStorage.setItem('lang', newLang);

                // Reload the page to apply language changes
                location.reload();
            }
        });
    }
}
// Initial load of language settings
window.addEventListener('load', initializeLanguage);

function redirectToLoginPage(pageName) {
    // Get the click and language parameters from the current URL
    const urlParams = new URLSearchParams(window.location.search);
    const clickValue = urlParams.get('click');
    const selectedLanguage = urlParams.get('lang');

    // Construct the URL for the desired page with both parameters
    let targetPageURL = '';
    switch (pageName) {
        case 'client-login':
            targetPageURL = 'client%20login.html';
            break;
        case 'staff-login':
            targetPageURL = 'Doctor%20login.html';
            break;
        case 'staff-reg':
            targetPageURL = 'Doctor%20Signup.html';
            break;
        case 'signup-client':
            targetPageURL = 'client%20Signup.html';
            break;
        default:
            // If an unsupported pageName is provided, default to client login
            //targetPageURL = 'client%20login.php';
            break;
    }

    // Append click and lang parameters to the constructed URL
    const loginPageURL = targetPageURL + '?click=' + clickValue + '&lang=' + selectedLanguage;
    // Redirect to the constructed URL
    window.location.href = loginPageURL;
}


window.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const clickParam = urlParams.get('click');

    if (clickParam === 'moon') {
        const moonElement = document.getElementById('moon');
        moonElement.click();
    }
});

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

    function getLangFromLocalStorage() {
        return localStorage.getItem('lang') || 'en'; // Default to 'en' if language is not set in local storage
    }

    // Append the query parameters based on the selected element
    let queryParams = '';
    if (selectedID === 'moon') {
        queryParams = 'click=moon&lang=' + getLangFromLocalStorage();
    } else if (selectedID === 'sun') {
        queryParams = 'click=sun&lang=' + getLangFromLocalStorage();
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
window.onscroll = function () { scrollFunction() };

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

// Wrap everything inside a window.onload event to make sure the DOM is fully loaded before accessing elements
window.onload = function () {
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModalBtn");
    // Get the button that opens the modal
    var btn2 = document.getElementById("openModalBtn2");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
        toggleMenu();
    }
    // When the user clicks the button, open the modal
    btn2.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
};
// Get the current year
var currentYear = new Date().getFullYear();

// Display it in the HTML
document.getElementById('currentYear').textContent = currentYear;


function toggleMenu() {

    var menu = document.getElementById("regular-display");
    if (menu.style.transform === "translateX(100%)" || menu.style.transform === "") {
        menu.style.transform = "translateX(0%)"; // Slide in
        menu.style.display = "block"; // Ensure the menu is displayed when sliding in
    } else {
        menu.style.transform = "translateX(100%)"; // Slide out
    }
}

// Ensure that the menu returns to normal when the window is resized larger than 700px
window.addEventListener('resize', function () {
    var menu = document.getElementById("regular-display");
    if (window.innerWidth > 700) {
        menu.style.removeProperty('transform');
        menu.style.removeProperty('display');
    } else if (menu.style.transform === "translateX(0%)") {
        // If the menu is open and the window is resized to be smaller than 700px, close the menu
        toggleMenu();
    }
});

// Initial setup for the menu to be hidden on page load at smaller screen sizes
document.addEventListener('DOMContentLoaded', function () {
    var menu = document.getElementById("regular-display");
    if (window.innerWidth <= 700) {
        menu.style.transform = "translateX(100%)";
    }
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        } else {
            entry.target.classList.remove('show');
        }
    });
});

const hiddenElements = document.querySelectorAll('.hiddin');
hiddenElements.forEach((el) => observer.observe(el));
