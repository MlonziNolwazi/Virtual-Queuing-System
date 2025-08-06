/**
 * Enables the submit button only when the terms checkbox is checked.
 * Adds event listener to toggle submit button state based on checkbox.
 */
function enableSubmitButton() {
    const checkbox = document.getElementById("termsCheck");
    const submitBtn = document.querySelector('button[type="submit"]');
    checkbox.addEventListener("change", () => {
        submitBtn.disabled = !checkbox.checked;
    });
}

/**
 * Adds password visibility toggle functionality to password fields
 * Allows users to show/hide password text with eye icon
 */
function enablePasswordToggle() {
    // Toggle for main password field
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");
    const passwordIcon = document.getElementById("passwordIcon");

    togglePassword.addEventListener("click", () => {
        // Toggle the type attribute
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;
        
        // Toggle the eye icon
        if (type === "password") {
            passwordIcon.classList.remove("fa-eye-slash");
            passwordIcon.classList.add("fa-eye");
        } else {
            passwordIcon.classList.remove("fa-eye");
            passwordIcon.classList.add("fa-eye-slash");
        }
    });

    // Toggle for confirm password field
    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
    const confirmPasswordField = document.getElementById("confirmPassword");
    const confirmPasswordIcon = document.getElementById("confirmPasswordIcon");

    toggleConfirmPassword.addEventListener("click", () => {
        // Toggle the type attribute
        const type = confirmPasswordField.type === "password" ? "text" : "password";
        confirmPasswordField.type = type;
        
        // Toggle the eye icon
        if (type === "password") {
            confirmPasswordIcon.classList.remove("fa-eye-slash");
            confirmPasswordIcon.classList.add("fa-eye");
        } else {
            confirmPasswordIcon.classList.remove("fa-eye");
            confirmPasswordIcon.classList.add("fa-eye-slash");
        }
    });
}

/**
 * Populates the signup form with sample data for testing purposes.
 * Sets predefined values for all form fields including name, email, passwords and terms checkbox.
 */
window.addEventListener("DOMContentLoaded", () => {
    enableSubmitButton();
    enablePasswordToggle();
});

/**
 * Validates a form field based on its ID and displays appropriate error messages.
 * @param {string} fieldId - The ID of the form field to validate
 * @returns {boolean} True if validation passes, false otherwise
 */
function validateField(fieldId) {
    const field = document.getElementById(fieldId); // Get the form field
    const errorContainer = document.getElementById(`${fieldId}-error`); // Get the error container

    // Check field is not empty
    if (!field.value) {
        errorContainer.textContent = 'This field is required!';
        return false;
    }

    // Check email format
    if(fieldId === "email") {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(field.value)) {
            errorContainer.textContent = "Please enter a valid email address.";
            return false;
        }
    }

    // Check password strength
    if(fieldId === "password") {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
        if(!passwordRegex.test(field.value)){
            errorContainer.textContent = "Password must be at least 8 characters long, contain uppercase and lowercase letters, a number, and a special character.";
            return false;
        }
    }

    // Check confirm password is the same as password
    if(fieldId === "confirmPassword") {
        if(field.value !== document.getElementById("password").value) {
            errorContainer.textContent = "Passwords do not match.";
            return false;
        }
    }
    errorContainer.textContent = "";
    return true;
}

function submitSignupData(data) {
    create ({ action: 'create_user', data }).then((response) => {
        console.log('The response for create user is -', response);
        debugger
        if (response && response?.isCreated) {
            // Displays a success notification using SweetAlert2 and redirects to the login page upon confirmation.
            Swal.fire({
                title: `Smart-Q Account Created`,
                text: `${response.message} - Login with your details!`,
                icon: "success"
            }).then((result) => {             
                if (result.isConfirmed) {
                    // Clear Fields once done with the process
                    const signUpForm = document.getElementById("signup-form");
                    signUpForm.reset();
                    // Redirect to login page
                    window.location.href = 'login.php';
                }
            });
        }
    });
}

// Handle form submission
const signUpSubmitButton = document.getElementById("signup-submit");
signUpSubmitButton.addEventListener("click", (event) => {
    event.preventDefault(); // Prevents the browser's default form submission behavior (page reload/redirect) so we can handle validation and API calls with JavaScript instead otherwise it will get interrupted.

    // Get form values at the time of submission
    const fullname = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const userType = document.getElementById("userType").value; 
    const password = document.getElementById("password").value;

    // Validate Fields
    const isFullNameValid = validateField("fullName");
    const isEmailValid = validateField("email");
    const isPasswordValid = validateField("password");
    const isConfirmPasswordValid = validateField("confirmPassword");

    // Check if all fields are valid
    if (isFullNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid && userType) {
        // Perform signup logic here
        submitSignupData({ fullname, email, password, userType });
    }
});

/**
 * Populates the signup form with sample data for testing purposes.
 * Sets predefined values for all form fields including name, email, passwords and terms checkbox.
 */
function populateSignupForm() {
    document.getElementById("fullName").value = "John Doe";
    document.getElementById("email").value = "john.doe@example.com";
    document.getElementById("password").value = "Password123#";
    document.getElementById("confirmPassword").value = "Password123#";
    document.getElementById("termsCheck").checked = true;
}

// Populate form with sample data - temporal
const populateDataButton = document.getElementById("populate-data");
populateDataButton.addEventListener("click", (event) => {
    event.preventDefault();
    populateSignupForm();
});
