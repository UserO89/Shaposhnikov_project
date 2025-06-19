<?php
require_once __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/User.php';

$auth = new Auth();
Auth::requireAdmin(); 

$user = new User();

$users = $user->getAll();

?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../partials/admin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Management</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>

            <?php renderFlashMessage() ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['first_name']); ?></td>
                            <td><?= htmlspecialchars($user['last_name']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                    <?= htmlspecialchars($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $user['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php foreach ($users as $user): ?>
                    <?php include __DIR__ . '/../modals/admin/delete_user.php'; ?>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../modals/admin/add_user.php'; ?>
<?php require_once __DIR__ . '/../modals/admin/edit_user.php'; ?>
<?php require_once __DIR__ . '/../modals/admin/delete_user.php'; ?>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 