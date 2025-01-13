document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.register-form');
    const nameInput = document.querySelector('#name');
    const surnameInput = document.querySelector('#surname');
    const emailInput = document.querySelector('#email');
    const passwordInput = document.querySelector('#password');
    const confirmPasswordInput = document.querySelector('#confirm_password');

    form.addEventListener('submit', function (event) {
        // Clear existing error messages
        document.querySelectorAll('.error-message').forEach(msg => msg.remove());

        let isValid = true;

        // Name validation
        if (nameInput.value.trim().length < 2) {
            showError(nameInput, 'Name must be at least 2 characters long.');
            isValid = false;
        }

        // Surname validation
        if (surnameInput.value.trim().length < 2) {
            showError(surnameInput, 'Surname must be at least 2 characters long.');
            isValid = false;
        }

        // Email validation
        if (!isValidEmail(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address.');
            isValid = false;
        }

        // Password validation
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters long.');
            isValid = false;
        }

        // Confirm Password validation
        if (confirmPasswordInput.value !== passwordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            isValid = false;
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Utility function to show error message
    function showError(input, message) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = 'red';
        error.style.fontSize = '14px';
        error.style.marginTop = '5px';
        error.innerText = message;
        input.parentElement.appendChild(error);
    }

    // Utility function to validate email format
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});