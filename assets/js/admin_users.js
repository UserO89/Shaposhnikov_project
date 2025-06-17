function editUser(user) {
    const fields = ['id', 'username', 'first_name', 'last_name', 'email', 'role'];
    fields.forEach(field => {
        const el = document.getElementById('edit_' + field);
        if (el) el.value = user[field] || '';
    });
    const passwordEl = document.getElementById('edit_password');
    if (passwordEl) passwordEl.value = '';
    const modal = document.getElementById('editUserModal');
    if (modal) new bootstrap.Modal(modal).show();
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = `/Shaposhnikov_project/actions/admin/users/delete.php?id=${userId}`;
    }
}