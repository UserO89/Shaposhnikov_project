<div class="col-md-4 mb-4 d-flex align-items-stretch">
    <a href="<?= BASE_PATH ?>/templates/course.php?id=<?= htmlspecialchars($course['id']) ?>" class="text-decoration-none text-dark w-100">
        <div class="card h-100">
            <img src="<?= htmlspecialchars($course['image_url'] ?: BASE_PATH . '/assets/img/placeholder.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 220px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                <p class="card-text flex-grow-1"><?= htmlspecialchars($course['description']) ?></p>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="badge bg-primary"><?= htmlspecialchars($course['category'] ?? 'N/A') ?></span>
                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" onclick="event.preventDefault(); editCourse(<?= htmlspecialchars(json_encode($course)) ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="<?= BASE_PATH ?>/actions/admin/courses/delete.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </a>
</div> 