<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="/Shaposhnikov_project/actions/auth/UpdateProfile.php" method="post">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required minlength="3" maxlength="50">
                        <div class="invalid-feedback" id="username_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required maxlength="50">
                        <div class="invalid-feedback" id="first_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required maxlength="50">
                        <div class="invalid-feedback" id="last_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        <div class="invalid-feedback" id="email_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" minlength="6" maxlength="100">
                        <div class="invalid-feedback" id="password_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password" minlength="6" maxlength="100">
                        <div class="invalid-feedback" id="confirm_password_error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/Shaposhnikov_project/assets/js/edit_profile_modal.js"></script>