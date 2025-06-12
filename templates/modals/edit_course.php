<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" action="<?php echo $base_path; ?>/actions/admin/edit_course.php" method="POST">
                    <input type="hidden" id="edit_course_id" name="id">
                    <div class="mb-3">
                        <label for="edit_course_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_course_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_course_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="edit_course_duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_course_price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_image" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="edit_course_image" name="image_url" placeholder="e.g., /assets/img/course1.jpg">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>