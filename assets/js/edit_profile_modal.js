document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.querySelector('#editProfileForm');
    if (!editForm) return;

    const fields = [
        {id: 'edit_username', error: 'username_error', required: true, min: 3, max: 50, label: 'Username'},
        {id: 'edit_first_name', error: 'first_name_error', required: true, min: 0, max: 50, label: 'First name'},
        {id: 'edit_last_name', error: 'last_name_error', required: true, min: 0, max: 50, label: 'Last name'},
        {id: 'edit_email', error: 'email_error', required: true, type: 'email', label: 'Email'}
    ];

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Reset previous error states
        document.querySelectorAll('.form-control').forEach(input => input.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(feedback => feedback.textContent = '');

        let isValid = true;

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.error);
            const value = input.value.trim();

            if (field.required && value === '') {
                input.classList.add('is-invalid');
                error.textContent = `${field.label} is required`;
                isValid = false;
            } else if (field.min && value.length < field.min) {
                input.classList.add('is-invalid');
                error.textContent = `${field.label} must be at least ${field.min} characters long`;
                isValid = false;
            } else if (field.max && value.length > field.max) {
                input.classList.add('is-invalid');
                error.textContent = `${field.label} must not exceed ${field.max} characters`;
                isValid = false;
            } else if (field.type === 'email') {
                const emailRegex = /^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$/;
                if (!emailRegex.test(value)) {
                    input.classList.add('is-invalid');
                    error.textContent = 'Invalid email format';
                    isValid = false;
                }
            }
        });

        // Password validation
        const passwordInput = document.getElementById('edit_password');
        const confirmPasswordInput = document.getElementById('edit_confirm_password');
        const passwordError = document.getElementById('password_error');
        const confirmPasswordError = document.getElementById('confirm_password_error');
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