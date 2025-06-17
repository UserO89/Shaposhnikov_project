# Course academy Web Application

A modular PHP web application for managing courses, featuring user authentication, personal profiles, and a powerful admin panel.  
Developed by **Vladislav Shaposhnikov**.

---

## 🚀 Features

- **User Registration & Login:** Secure authentication system with session management.
- **Personal Profile Page:** Each user has a customizable profile.
- **Course Catalog:** Browse, search, and view detailed information about available courses.
- **Course Reviews:** Courses display reviews, stored in the database.
- **Admin Panel:** Admins can create, edit, delete, and manage all courses and users.
- **Modern UI:** Responsive design with Bootstrap (CSS/JS assets included).
- **Modular Codebase:** Clean structure using OOP (PHP Classes), separated templates, and actions.

---

## 📁 Project Structure
Shaposhnikov_project-main/ <br>
│<br>
├── Classes/ # Core PHP classes: User, Course, Auth, DB, Validator, SessionMessage<br>
├── actions/ # Business logic for admin and user actions<br>
├── assets/ # Static files: CSS, JavaScript, images + database dump<br>
├── config/ # Configuration files (DB connection info, app config)<br>
├── templates/ # Page templates (Home, Profile, Courses, Admin, Partials, their modals)<br>
└── index.php # Main entry point; redirects to profile or home<br>

---

## ⚙️ Installation & Local Setup

1. **Clone or Download the repository**
   ```bash
   git clone https://github.com/your-username/Shaposhnikov_project-main.gi

2. **Copy files to your local PHP server root**<br>
(e.g., htdocs in XAMPP, www in MAMP/LAMP)

3. **Set up the Database**

- Create a MySQL database (e.g., course_app).

- Import the database schema and sample data (if provided).

- Update config/DBInfo.php with your DB credentials:

```bash
define('DB_HOST', 'localhost');
define('DB_NAME', 'course_app');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
```
4. **Start your local server** <br>
Visit http://localhost/Shaposhnikov_project-main/index.php

Default Admin Login

(If provided, use the default admin credentials, or register a new user and update their role to admin in the database.)

--- 

## 🖥️ Main Pages

- **Home:** `/templates/home.php` — Landing page with intro and course highlights  
- **Courses:** `/templates/courses.php` — Full course catalog and details  
- **Profile:** `/templates/profile.php` — User dashboard and info  
- **Admin Panel:** `/templates/admin/` — Course CRUD operations (admin only)  

---

## 🛠️ Technologies Used

- **PHP 8.x+** (Object-Oriented)
- **MySQL/MariaDB** (via PDO)
- **HTML5, CSS3, JavaScript**
- **Bootstrap 5** (for UI/UX)
- **Modular folder structure** (separation of concerns)

---

## 🤝 Contributing

Pull requests, bug reports, and suggestions are welcome!  
Feel free to **fork**, ⭐ star, or **open issues** on GitHub.
