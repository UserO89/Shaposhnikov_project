<div class="modal fade" id="editCourseModal<?= $course['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm<?= $course['id'] ?>" action="<?= BASE_PATH ?>/actions/admin/courses/edit.php" method="POST">
                    <input type="hidden" id="edit_course_id<?= $course['id'] ?>" name="id" value="<?= htmlspecialchars($course['id']) ?>">
                    <div class="mb-3">
                        <label for="edit_title<?= $course['id'] ?>" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title<?= $course['id'] ?>" name="title" value="<?= htmlspecialchars($course['title']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description<?= $course['id'] ?>" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description<?= $course['id'] ?>" name="description" rows="3" required><?= htmlspecialchars($course['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category<?= $course['id'] ?>" class="form-label">Category</label>
                        <select class="form-select" id="edit_category<?= $course['id'] ?>" name="category" required>
                            <option value="">Select a category</option>
                            <?php
                            if (!isset($categories) || !is_array($categories)) {
                                $categories = (new \Course())->getAllCategories();
                            }
                            foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['name']); ?>"<?= $cat['name'] === $course['category'] ? ' selected' : '' ?>><?= htmlspecialchars($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_duration<?= $course['id'] ?>" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="edit_duration<?= $course['id'] ?>" name="duration" value="<?= htmlspecialchars($course['duration']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price<?= $course['id'] ?>" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price<?= $course['id'] ?>" name="price" step="0.01" value="<?= htmlspecialchars($course['price']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image<?= $course['id'] ?>" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="edit_image<?= $course['id'] ?>" name="image_url" placeholder="e.g., /assets/img/course1.jpg" value="<?= htmlspecialchars($course['image_url']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>