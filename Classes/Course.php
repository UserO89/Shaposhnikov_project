<?php
require_once __DIR__ . '/Database.php';

class Course extends Database
{
    private $id;
    private $title;
    private $description;
    private $duration;
    private $price;
    private $image;
    private $created_at;

    public function __construct()
    {
        parent::__construct();
    }

    // Получить курс по ID
    public function getById($id)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить курс по названию
    public function getByTitle($title)
    {
        $stmt = $this->getConnection()->prepare("SELECT * FROM courses WHERE title = ?");
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Получить все курсы
    public function getAll()
    {
        $stmt = $this->getConnection()->query("SELECT * FROM courses ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Создать новый курс
    public function create($data)
    {
        try {
            // Валидация данных
            $this->validateCourseData($data);

            // Проверка на существующий курс с таким названием
            if ($this->getByTitle($data['title'])) {
                throw new Exception('Course with this title already exists');
            }

            // Подготовка SQL запроса
            $sql = "INSERT INTO courses (title, description, duration, price, image, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                $data['title'],
                $data['description'],
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
    public function update($id, $data)
    {
        try {
            // Валидация данных
            $this->validateCourseData($data, true);

            // Проверка существования курса
            $course = $this->getById($id);
            if (!$course) {
                throw new Exception('Course not found');
            }

            // Проверка на существующий курс с таким названием (исключая текущий курс)
            $existingCourse = $this->getByTitle($data['title']);
            if ($existingCourse && $existingCourse['id'] != $id) {
                throw new Exception('Course with this title already exists');
            }

            // Подготовка данных для обновления
            $updateData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'duration' => $data['duration'],
                'price' => $data['price']
            ];

            // Если указано новое изображение, добавляем его в обновление
            if (!empty($data['image'])) {
                $updateData['image'] = $data['image'];
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

        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
    }

    // Поиск курсов
    public function search($query)
    {
        $search = "%$query%";
        $sql = "SELECT * FROM courses 
                WHERE title LIKE ? 
                OR description LIKE ? 
                OR duration LIKE ? 
                ORDER BY created_at DESC";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить количество курсов
    public function getCount()
    {
        $stmt = $this->getConnection()->query("SELECT COUNT(*) FROM courses");
        return $stmt->fetchColumn();
    }

    // Получить курсы с пагинацией
    public function getPaginated($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM courses ORDER BY created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы по цене (фильтр)
    public function getByPriceRange($minPrice, $maxPrice)
    {
        $sql = "SELECT * FROM courses WHERE price >= ? AND price <= ? ORDER BY price ASC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$minPrice, $maxPrice]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить курсы по длительности (фильтр)
    public function getByDuration($duration)
    {
        $sql = "SELECT * FROM courses WHERE duration = ? ORDER BY created_at DESC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$duration]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить самые популярные курсы (по количеству записей)
    public function getPopular($limit = 5)
    {
        $sql = "SELECT c.*, COUNT(e.id) as enrollment_count 
                FROM courses c 
                LEFT JOIN enrollments e ON c.id = e.course_id 
                GROUP BY c.id 
                ORDER BY enrollment_count DESC 
                LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получить последние добавленные курсы
    public function getLatest($limit = 5)
    {
        $sql = "SELECT * FROM courses ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}