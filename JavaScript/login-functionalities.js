// Function to handle form submission when pressing Enter key
function handleKeyPress(event) {
    if (event.keyCode === 13) { // Check if Enter key is pressed
        event.preventDefault(); // Prevent default form submission
        document.getElementById('enter').click(); // Manually submit the form
    }
}

const passwordInput = document.getElementById('password');
const toggleButton = document.getElementById('toggleBtn');

toggleButton.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    toggleButton.textContent = 'Hide';
    } else {
    passwordInput.type = 'password';
    toggleButton.textContent = 'Show';
    }
});