function editCourse(course) {
    console.log("Course object:", course);
    document.getElementById('edit_course_id').value = course.id;
    document.getElementById('edit_title').value = course.title;
    document.getElementById('edit_description').value = course.description;
    document.getElementById('edit_category').value = course.category;
    document.getElementById('edit_duration').value = course.duration;
    document.getElementById('edit_price').value = course.price;
    document.getElementById('edit_image').value = course.image_url;
    
    new bootstrap.Modal(document.getElementById('editCourseModal')).show();
}

function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course?')) {
        window.location.href = `/Shaposhnikov_project/actions/admin/delete_course.php?id=${courseId}`;
    }
} 