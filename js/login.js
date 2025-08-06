/**
 * Login form functionality for Smart-Q
 * Handles user authentication and form validation
 */

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const loginSubmit = document.getElementById('login-submit');

    // Enable password visibility toggle
    enablePasswordToggle();

    // Clear error messages when user starts typing
    emailInput.addEventListener('input', () => clearError('email'));
    passwordInput.addEventListener('input', () => clearError('password'));

    // Form submission handler
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateLoginForm()) {
            return;
        }

        // Disable submit button during login
        loginSubmit.disabled = true;
        loginSubmit.textContent = 'Logging in...';

        const formData = {
            email: emailInput.value.trim(),
            password: passwordInput.value,
            action: 'login_user'
        };

        try {
            const response = await auth({ 
                action: 'authenticate_user', 
                data: { 
                    email: formData.email, 
                    password: formData.password 
                } 
            });

            console.log('Login response:', response);

            if (response && response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    text: `Welcome back, ${response.user?.fullname || 'User'}!`,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Store user session data if needed
                    if (response.user) {
                        localStorage.setItem('user', JSON.stringify(response.user));
                    }
                    
                    // Redirect based on user role
                    let redirectUrl = 'admin_dashboard.php'; // Default
                
                    
                    window.location.href = redirectUrl;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: response.message || 'Invalid email or password'
                });
            }
        } catch (error) {
            console.error('Login error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while logging in. Please try again.'
            });
        } finally {
            // Re-enable submit button
            loginSubmit.disabled = false;
            loginSubmit.textContent = 'Login';
        }
    });

    /**
     * Validates the login form fields
     * @returns {boolean} True if validation passes, false otherwise
     */
    function validateLoginForm() {
        let isValid = true;

        // Clear previous errors
        clearAllErrors();

        // Validate email
        const email = emailInput.value.trim();
        if (!email) {
            showError('email', 'Email is required');
            isValid = false;
        } else if (!isValidEmail(email)) {
            showError('email', 'Please enter a valid email address');
            isValid = false;
        }

        // Validate password
        const password = passwordInput.value;
        if (!password) {
            showError('password', 'Password is required');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Validates email format using regex
     * @param {string} email - Email to validate
     * @returns {boolean} True if email is valid
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Shows error message for a specific field
     * @param {string} fieldId - ID of the field
     * @param {string} message - Error message to display
     */
    function showError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + '-error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    /**
     * Clears error message for a specific field
     * @param {string} fieldId - ID of the field
     */
    function clearError(fieldId) {
        const errorElement = document.getElementById(fieldId + '-error');
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    /**
     * Clears all error messages
     */
    function clearAllErrors() {
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(element => {
            element.textContent = '';
            element.style.display = 'none';
        });
    }

    /**
     * Adds password visibility toggle functionality to password field
     * Allows users to show/hide password text with eye icon
     */
    function enablePasswordToggle() {
        const togglePassword = document.getElementById("togglePassword");
        const passwordField = document.getElementById("password");
        const passwordIcon = document.getElementById("passwordIcon");

        if (togglePassword && passwordField && passwordIcon) {
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
        }
    }
});
