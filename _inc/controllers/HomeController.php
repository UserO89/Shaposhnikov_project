<?php
require_once __DIR__ . '/BaseController.php';

class HomeController extends BaseController {
    public function index() {
        // Fetch featured courses from database
        $query = "SELECT * FROM courses WHERE featured = 1 LIMIT 6";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $featuredCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch testimonials
        $query = "SELECT * FROM testimonials LIMIT 2";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('home', [
            'featuredCourses' => $featuredCourses,
            'testimonials' => $testimonials
        ]);
    }
}
?> 