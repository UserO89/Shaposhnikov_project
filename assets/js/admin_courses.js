function editCourse(course) {
    const fields = ['id', 'title', 'description', 'category', 'duration', 'price'];
    fields.forEach(field => {
        const el = document.getElementById('edit_' + field);
        if (el) el.value = course[field] || '';
    });
    const imageEl = document.getElementById('edit_image');
    if (imageEl) imageEl.value = course.image_url || '';
    const modal = document.getElementById('editCourseModal');
    if (modal) new bootstrap.Modal(modal).show();
}

function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course?')) {
        window.location.href = `/Shaposhnikov_project/actions/admin/courses/delete.php?id=${courseId}`;
    }
} 