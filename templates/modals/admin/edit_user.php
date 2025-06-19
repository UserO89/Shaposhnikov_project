<div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASE_PATH ?>/actions/admin/users/edit.php" method="POST">
                <input type="hidden" id="edit_user_id<?= $user['id'] ?>" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_username<?= $user['id'] ?>" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username<?= $user['id'] ?>" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_first_name<?= $user['id'] ?>" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name<?= $user['id'] ?>" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_last_name<?= $user['id'] ?>" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name<?= $user['id'] ?>" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email<?= $user['id'] ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email<?= $user['id'] ?>" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password<?= $user['id'] ?>" class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password<?= $user['id'] ?>" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_role<?= $user['id'] ?>" class="form-label">Role</label>
                        <select class="form-select" id="edit_role<?= $user['id'] ?>" name="role" required>
                            <option value="student"<?= $user['role'] === 'student' ? ' selected' : '' ?>>Student</option>
                            <option value="admin"<?= $user['role'] === 'admin' ? ' selected' : '' ?>>Admin</option>
                            <option value="teacher"<?= $user['role'] === 'teacher' ? ' selected' : '' ?>>Teacher</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>