function editUser(user) {
    document.getElementById('edit_user_id').value = user.id;
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_first_name').value = user.first_name;
    document.getElementById('edit_last_name').value = user.last_name;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_role').value = user.role;
    document.getElementById('edit_password').value = '';
    
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = `/Shaposhnikov_project/actions/admin/delete_user.php?id=${userId}`;
    }
} 