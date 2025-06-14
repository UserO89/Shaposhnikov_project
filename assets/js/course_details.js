document.addEventListener('DOMContentLoaded', function() {
    const enrollButton = document.getElementById('enrollButton');
    if (enrollButton) {
        enrollButton.addEventListener('click', function() {
            const courseId = this.dataset.courseId;
            
            fetch('../actions/user/EnrollCourse.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'course_id=' + courseId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload(); // Reload to show updated status
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during enrollment.');
            });
        });
    }
}); 