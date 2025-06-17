<?php if (!empty($reviews)): ?>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Customer Reviews</h5>
            <?php foreach ($reviews as $review): ?>
                <div class="mb-3 pb-3 border-bottom">
                    <p class="mb-1">
                        <strong><?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']) ?></strong>
                        <small class="text-muted float-end">
                            <?= htmlspecialchars(date('M d, Y', strtotime($review['created_at']))) ?>
                        </small>
                    </p>
                    <div>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa<?= ($i <= $review['rating']) ? 's' : 'r' ?> fa-star text-warning"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mt-2">"<?= nl2br(htmlspecialchars($review['text'])) ?>"</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?> 