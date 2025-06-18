<?php
function renderStatCard($icon, $value, $label, $bg) {
    echo "
    <div class=\"col-md-6 col-lg-3 mb-4\">
        <div class=\"card text-center $bg text-white h-100 d-flex flex-column justify-content-center\">
            <div class=\"card-body\">
                <i class=\"fas $icon fa-3x mb-3\"></i>
                <h3 class=\"card-title display-4 fw-bold\">$value</h3>
                <p class=\"card-text fs-5\">$label</p>
            </div>
        </div>
    </div>
    ";
}

function renderFlashMessage() {
    if (class_exists('SessionMessage') && SessionMessage::hasMessages()) {
        $message = SessionMessage::get();
        if ($message) {
            echo '<div class="alert alert-' . htmlspecialchars($message['type']) . ' alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($message['message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
        }
    }
} 