document.getElementById("Phone").addEventListener("input", function() {
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});

document.getElementById("Emp_ID").addEventListener("input", function() {
    if (this.value.length > 4) {
        this.value = this.value.slice(0, 4);
    }
});

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
