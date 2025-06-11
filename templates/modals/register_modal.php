<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="../index.php?route=register" method="POST">
          <div class="mb-3">
            <label for="reg_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="reg_username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="reg_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="reg_email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="reg_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="reg_password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="reg_confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="reg_confirm_password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>