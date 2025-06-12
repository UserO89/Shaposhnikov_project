<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm" action="<?php echo $base_path; ?>/actions/admin/add_course.php" method="POST">
                    <div class="mb-3">
                        <label for="course_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="course_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_description" class="form-label">Description</label>
                        <textarea class="form-control" id="course_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="course_duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="course_duration" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="course_price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_image" class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="course_image" name="image_url" placeholder="e.g., /assets/img/course1.jpg">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</div>