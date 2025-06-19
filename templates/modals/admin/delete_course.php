<?php if (isset($course)): ?>
<div class="modal fade" id="deleteCourseModal<?= $course['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete course <strong><?= htmlspecialchars($course['title']) ?></strong>?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="<?= BASE_PATH ?>/actions/admin/courses/delete.php">
                    <input type="hidden" name="id" value="<?= $course['id'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 