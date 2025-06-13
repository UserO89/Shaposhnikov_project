<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Определяем базовый путь
if (!isset($base_path)) {
    $base_path = '/Shaposhnikov_project';
}

require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

Auth::requireAdmin();

$courses = [];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->query("SELECT id, title, description, duration, price, image_url FROM courses ORDER BY id DESC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'Database error: ' . $e->getMessage();
    error_log("Database error in admin_courses.php: " . $e->getMessage());
}

// Включаем header после всех PHP-операций
require_once __DIR__ . '/../partials/header.php';
?>

<main class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Admin Panel</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="admin_users.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                    <a href="/templates/admin/courses.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-book me-2"></i> Courses
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Course Management</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    <i class="fas fa-plus"></i> Add Course
                </button>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Courses Grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $index => $course): ?>
                    <div class="col">
                        <a href="<?= $base_path ?>/templates/course.php?id=<?= htmlspecialchars($course['id']) ?>" class="text-decoration-none text-dark">
                            <div class="card h-100 course-card">
                                <img src="<?php echo htmlspecialchars($course['image_url'] ?? '/assets/img/default-course.jpg'); ?>" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars(mb_substr($course['description'] ?? '', 0, 100)) . '...'; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($course['duration']); ?></span>
                                        <span class="text-primary fw-bold"><?php 
                                            $price = $course['price'] ?? 0;
                                            // Remove any currency symbols and convert to float
                                            $price = is_string($price) ? (float) preg_replace('/[^0-9.]/', '', $price) : (float) $price;
                                            echo '$' . number_format($price, 2); 
                                        ?></span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); editCourse(<?php echo $course['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo $base_path; ?>/actions/admin/delete_course.php" method="POST" class="d-inline" onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this course?');">
                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">No courses found.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Course Modal -->
<?php
require_once("../modals/add_course.php");
require_once("../modals/edit_course.php");
?>

<style>
.card {
    transition: transform 0.2s;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.list-group-item {
    border: none;
    padding: 0.75rem 1.25rem;
}

.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.badge {
    padding: 0.5em 0.75em;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.alert {
    margin-bottom: 1rem;
}
</style>

<script>

function editCourse(courseId) {
    // Fetch course data from the server
    fetch(`/Shaposhnikov_project/actions/admin/get_course.php?id=${courseId}`)
        .then(response => response.json())
        .then(course => {
            if (course) {
                document.getElementById('edit_course_id').value = course.id;
                document.getElementById('edit_course_title').value = course.title;
                document.getElementById('edit_course_description').value = course.description;
                document.getElementById('edit_course_duration').value = course.duration;
                document.getElementById('edit_course_price').value = course.price;
                document.getElementById('edit_course_image').value = course.image_url || '';

                const editModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
                editModal.show();
            } else {
                console.error('Course not found for ID:', courseId);
                alert('Error: Course not found');
            }
        })
        .catch(error => {
            console.error('Error fetching course data:', error);
            alert('Error loading course data');
        });
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 