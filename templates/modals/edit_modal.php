<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="/Shaposhnikov_project/actions/user/UpdateProfile.php" method="post">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="edit_confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="edit_confirm_password" name="confirm_password">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.querySelector('#editProfileForm');
    editForm.addEventListener('submit', function(e) {
        console.log('Edit profile form submitted via JavaScript.');
        
        const password = document.getElementById('edit_password').value;
        const confirmPassword = document.getElementById('edit_confirm_password').value;
        
        if (password || confirmPassword) {
            if (password.length < 6) {
                alert('Password must be at least 6 characters long');
                return;
            }
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
        }
        
        this.submit();
    });
});
</script>

<style>
#profilePhotoPreview {
    border: 3px solid #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

#profilePhotoPreview:hover {
    opacity: 0.9;
}

.fa-camera {
    font-size: 1.2rem;
}

label[for="profilePhoto"]:hover {
    background-color: #0056b3 !important;
}
</style>