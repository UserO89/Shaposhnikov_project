document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.querySelector('#editProfileForm');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset previous error states
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.textContent = '';
        });

        let isValid = true;

        const usernameInput = document.getElementById('edit_username');
        const firstNameInput = document.getElementById('edit_first_name');
        const lastNameInput = document.getElementById('edit_last_name');
        const emailInput = document.getElementById('edit_email');
        const passwordInput = document.getElementById('edit_password');
        const confirmPasswordInput = document.getElementById('edit_confirm_password');

        const usernameError = document.getElementById('username_error');
        const firstNameError = document.getElementById('first_name_error');
        const lastNameError = document.getElementById('last_name_error');
        const emailError = document.getElementById('email_error');
        const passwordError = document.getElementById('password_error');
        const confirmPasswordError = document.getElementById('confirm_password_error');

        // Username validation
        if (usernameInput.value.trim() === '') {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = 'Username is required';
            isValid = false;
        } else if (usernameInput.value.trim().length < 3) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = 'Username must be at least 3 characters long';
            isValid = false;
        } else if (usernameInput.value.trim().length > 50) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = 'Username must not exceed 50 characters';
            isValid = false;
        }

        // First Name validation
        if (firstNameInput.value.trim() === '') {
            firstNameInput.classList.add('is-invalid');
            firstNameError.textContent = 'First name is required';
            isValid = false;
        } else if (firstNameInput.value.trim().length > 50) {
            firstNameInput.classList.add('is-invalid');
            firstNameError.textContent = 'First name must not exceed 50 characters';
            isValid = false;
        }

        // Last Name validation
        if (lastNameInput.value.trim() === '') {
            lastNameInput.classList.add('is-invalid');
            lastNameError.textContent = 'Last name is required';
            isValid = false;
        } else if (lastNameInput.value.trim().length > 50) {
            lastNameInput.classList.add('is-invalid');
            lastNameError.textContent = 'Last name must not exceed 50 characters';
            isValid = false;
        }

        // Email validation
        const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        if (emailInput.value.trim() === '') {
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Email is required';
            isValid = false;
        } else if (!emailRegex.test(emailInput.value.trim())) {
            emailInput.classList.add('is-invalid');
            emailError.textContent = 'Invalid email format';
            isValid = false;
        }

        // Password validation
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (password || confirmPassword) {
            if (password.length < 6) {
                passwordInput.classList.add('is-invalid');
                passwordError.textContent = 'Password must be at least 6 characters long';
                isValid = false;
            } else if (password.length > 100) {
                passwordInput.classList.add('is-invalid');
                passwordError.textContent = 'Password must not exceed 100 characters';
                isValid = false;
            }
            if (password !== confirmPassword) {
                confirmPasswordInput.classList.add('is-invalid');
                confirmPasswordError.textContent = 'Passwords do not match';
                isValid = false;
            }
        }

        if (isValid) {
            this.submit();
        }
    });
}); 