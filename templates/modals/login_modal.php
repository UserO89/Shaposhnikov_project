<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASE_PATH ?>/actions/user/Login.php" method="POST">
          <div class="mb-3">
            <label for="login_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="login_username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="login_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="login_password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>