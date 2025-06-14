<?php
require_once __DIR__ . '/Database.php';

class Course extends Database
{
    private $id;
    private $title;
    private $description;
    private $category_id;
    private $duration;
    private $price;
    private $image_url;
    private $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    // Вспомогательный метод для получения ID категории по имени
    private function getCategoryIdByName($categoryName)
    {
        $stmt = $this->getConnection()->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$categoryName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // Получить курс по ID
    public function getById($id)
    {
        $sql = "SELECT c.*, cat.name AS category 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id 
                WHERE c.id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить курс по названию
    public function getByTitle($title)
    {
        $stmt = $this->getConnection()->prepare("SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id WHERE c.title = ?");
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить все курсы  -----------------------------------------------------
    public function getAll()
    {
        $sql = "SELECT c.*, cat.name AS category 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id 
                ORDER BY c.created_at DESC";
        $stmt = $this->getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Создать новый курс --------------------------------------------------------
    public function create($data)
    {
        try {
            // Валидация данных
            $this->validateCourseData($data);

            // Получить category_id по имени
            $categoryId = $this->getCategoryIdByName($data['category']);
            if (is_null($categoryId)) {
                throw new Exception('Invalid category selected.');
            }

            // Проверка на существующий курс с таким названием
            if ($this->getByTitle($data['title'])) {
                throw new Exception('Course with this title already exists');
            }

            // Подготовка SQL запроса
            $sql = "INSERT INTO courses (title, description, category_id, duration, price, image_url, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                $data['title'],
                $data['description'],
                $categoryId,
                $data['duration'],
                $data['price'],
                $data['image'] ?? null
            ]);

            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Error creating course: ' . $e->getMessage());
        }
    }

    // Обновить данные курса
    public function update($id, $data) //------------------------------------------------
    {
        try {
            // Валидация данных
            $this->validateCourseData($data, true);

            // Получить category_id по имени
            $categoryId = $this->getCategoryIdByName($data['category']);
            if (is_null($categoryId)) {
                throw new Exception('Invalid category selected.');
            }

            // Проверка существования курса
            $course = $this->getById($id);
            if (!$course) {
                throw new Exception('Course not found');
            }

            // Проверка на существующий курс с таким названием (исключая текущий курс)
            $existingCourse = $this->getByTitle($data['title']);
            if ($existingCourse && $existingCourse['id'] != $id && $existingCourse['category_id'] == $categoryId) {
                throw new Exception('Course with this title already exists in this category.');
            }

            // Подготовка данных для обновления
            $updateData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'category_id' => $categoryId, // Обновляем category_id
                'duration' => $data['duration'],
                'price' => $data['price']
            ];

            // Если указано новое изображение, добавляем его в обновление
            if (!empty($data['image'])) {
                $updateData['image_url'] = $data['image'];
            }

            // Формирование SQL запроса
            $sql = "UPDATE courses SET ";
            $params = [];
            foreach ($updateData as $key => $value) {
                $sql .= "$key = ?, ";
                $params[] = $value;
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = ?";
            $params[] = $id;

            // Выполнение запроса
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);

            return true;
        } catch (Exception $e) {
            throw new Exception('Error updating course: ' . $e->getMessage());
        }
    }

    // Удалить курс
    public function delete($id)
    {
        try {
            $stmt = $this->getConnection()->prepare("DELETE FROM courses WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            throw new Exception('Error deleting course: ' . $e->getMessage());
        }
    }

    // Валидация данных курса
    private function validateCourseData($data, $isUpdate = false)
    {
        $errors = [];

        // Проверка обязательных полей
        if (empty($data['title'])) {
            $errors[] = 'Title is required';
        }
        if (empty($data['description'])) {
            $errors[] = 'Description is required';
        }
        if (empty($data['category'])) {
            $errors[] = 'Category is required';
        }
        if (empty($data['duration'])) {
            $errors[] = 'Duration is required';
        }
        if (!isset($data['price']) || $data['price'] < 0) {
            $errors[] = 'Valid price is required';
        }

        // Проверка длины полей
        if (strlen($data['title']) > 255) {
            $errors[] = 'Title must be less than 255 characters';
        }
        if (strlen($data['description']) > 1000) {
            $errors[] = 'Description must be less than 1000 characters';
        }

        // Проверка формата цены
        if (!is_numeric($data['price'])) {
            $errors[] = 'Price must be a number';
        }

        // Проверка допустимых категорий (теперь через базу данных)
        $categoryId = $this->getCategoryIdByName($data['category']);
        if (is_null($categoryId)) {
            $errors[] = 'Invalid category selected';
        }

        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
    }

    // Поиск курсов -----------------------------------------------------------------------------
    public function search($query)
    {
        $search = "%$query%";
        $sql = "SELECT c.*, cat.name AS category 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id 
                WHERE c.title LIKE ? 
                OR c.description LIKE ? 
                OR c.duration LIKE ? 
                OR cat.name LIKE ? 
                ORDER BY c.created_at DESC";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$search, $search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить количество курсов  -----------------------------------------------------------------------------
    public function getCount()
    {
        $stmt = $this->getConnection()->query("SELECT COUNT(*) FROM courses");
        return $stmt->fetchColumn();
    }

    // Получить курсы с пагинацией ------------------------------------------------------------------------------------
    public function getPaginated($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы по цене (фильтр) ------------------------------------------------------------------------------------------
    public function getByPriceRange($minPrice, $maxPrice)
    {
        $sql = "SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id WHERE c.price >= ? AND c.price <= ? ORDER BY c.price ASC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$minPrice, $maxPrice]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы по длительности (фильтр) -----------------------------------------------------------
    public function getByDuration($duration)
    {
        $sql = "SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id WHERE c.duration = ? ORDER BY c.created_at DESC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$duration]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить самые популярные курсы (по количеству записей) -----------------------------------------------------
    public function getPopular($limit = 5)
    {
        $sql = "SELECT c.*, cat.name AS category, COUNT(e.id) as enrollment_count 
                FROM courses c 
                LEFT JOIN enrollments e ON c.id = e.course_id 
                JOIN categories cat ON c.category_id = cat.id 
                GROUP BY c.id 
                ORDER BY enrollment_count DESC 
                LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить последние N курсов
    public function getRecentCourses($limit = 5)
    {
        $sql = "SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить количество курсов, добавленных за последние 30 дней
    public function getCoursesCountLast30Days()
    {
        $sql = "SELECT COUNT(c.id) FROM courses c JOIN categories cat ON c.category_id = cat.id WHERE c.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        $stmt = $this->getConnection()->query($sql);
        return $stmt->fetchColumn();
    }

    // Получить последние N курсов (по дате добавления) -----------------------------------------------------
    public function getLatest($limit = 5)
    {
        $sql = "SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы с самым высоким рейтингом (пример) -----------------------------------------------------
    public function getTopRated($limit = 3)
    {
        $sql = "SELECT c.*, cat.name AS category, AVG(r.rating) as avg_rating 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id
                LEFT JOIN reviews r ON c.id = r.course_id 
                GROUP BY c.id 
                ORDER BY avg_rating DESC 
                LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы с применением фильтров
    public function getFilteredCourses($filters = [])
    {
        $sql = "SELECT c.*, cat.name AS category 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id ";
        $conditions = [];
        $params = [];

        if (!empty($filters['category'])) {
            $categoryId = $this->getCategoryIdByName($filters['category']);
            if ($categoryId) {
                $conditions[] = "c.category_id = ?";
                $params[] = $categoryId;
            }
        }

        if (isset($filters['min_price']) && is_numeric($filters['min_price'])) {
            $conditions[] = "c.price >= ?";
            $params[] = $filters['min_price'];
        }

        if (isset($filters['max_price']) && is_numeric($filters['max_price'])) {
            $conditions[] = "c.price <= ?";
            $params[] = $filters['max_price'];
        }

        if (isset($filters['max_duration']) && is_numeric($filters['max_duration'])) {
            $conditions[] = "c.duration <= ?";
            $params[] = $filters['max_duration'];
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY c.created_at DESC";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить все категории
    public function getAllCategories()
    {
        $stmt = $this->getConnection()->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}