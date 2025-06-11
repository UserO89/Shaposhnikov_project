<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../Classes/Auth.php';
require_once __DIR__ . '/../../Classes/Database.php';

// Проверка прав администратора
Auth::requireAdmin();

$courses = [];
$json_file_path = __DIR__ . '/../../assets/info.json'; 

if (file_exists($json_file_path)) {
    $json_content = file_get_contents($json_file_path);
    if ($json_content === false) {
        // Логирование ошибки, но не умираем, чтобы страница загрузилась хоть как-то
        error_log("Failed to read info.json in admin_courses.php: " . error_get_last()['message']);
        $_SESSION['errors'][] = 'Ошибка: Не удалось прочитать содержимое файла info.json.';
    } else {
        $decoded_json = json_decode($json_content, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_json)) {
            $courses = $decoded_json;
        } else {
            error_log("JSON Decode Error in admin_courses.php: " . json_last_error_msg());
            $_SESSION['errors'][] = 'Ошибка: Некорректный формат JSON в файле info.json.';
        }
    }
} else {
    $_SESSION['errors'][] = 'Ошибка: Файл info.json не найден по пути: ' . htmlspecialchars($json_file_path);
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
                    <a href="<?php echo $base_path; ?>/templates/admin/dashboard.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="<?php echo $base_path; ?>/templates/admin/admin_users.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                    <a href="<?php echo $base_path; ?>/templates/admin/courses.php" class="list-group-item list-group-item-action active">
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
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($course['image'] ?? '/assets/img/default-course.jpg'); ?>" 
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
                                    <button class="btn btn-sm btn-outline-primary" onclick="editCourse(<?php echo $index; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?php echo $base_path; ?>/templates/admin/delete_course.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id'] ?? $index); ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm" action="<?php echo $base_path; ?>/templates/admin/add_course.php" method="POST">
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
                        <input type="text" class="form-control" id="course_image" name="image" placeholder="e.g., /assets/img/course1.jpg">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" action="<?php echo $base_path; ?>/templates/admin/edit_course.php" method="POST">
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
                        <input type="text" class="form-control" id="edit_course_image" name="image" placeholder="e.g., /assets/img/course1.jpg">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
const coursesData = <?php echo json_encode($courses); ?>;

function editCourse(index) {
    const course = coursesData[index];
    if (course) {
        document.getElementById('edit_course_id').value = course.id;
        document.getElementById('edit_course_title').value = course.title;
        document.getElementById('edit_course_description').value = course.description;
        document.getElementById('edit_course_duration').value = course.duration;
        document.getElementById('edit_course_price').value = course.price;
        document.getElementById('edit_course_image').value = course.image || '';

        const editModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
        editModal.show();
    } else {
        console.error('Course not found for index:', index);
    }
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 