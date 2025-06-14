<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/Shaposhnikov_project/actions/admin/add_user.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="register_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="register_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="register_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="register_first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="register_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="register_last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="register_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="register_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>