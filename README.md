# Student Record System

A simple web application for managing student records using PHP and MySQL.

## Features

- Secure login system with PHP sessions
- Add, edit, and delete student records
- Minimalist UI with light and dark mode toggle
- Clean, responsive design
- PDO for secure database queries

## Setup Instructions

1. **Database Setup:**
   - Run the `create_database.sql` script in your MySQL server to create the database and tables.
   - Default login: username `admin`, password `password`

2. **Web Server:**
   - Place all files in your web server's document root (e.g., `c:\laragon\www\Dumagat_2` for Laragon).
   - Ensure PHP and MySQL are running.

3. **Access the Application:**
   - Open `http://localhost/Dumagat_2/login.php` in your browser.
   - Log in with the default credentials.

## Files Overview

- `config.php`: Database connection configuration
- `login.php`: Login page
- `logout.php`: Logout functionality
- `dashboard.php`: Main dashboard displaying student records
- `add_student.php`: Form to add new students
- `edit_student.php`: Form to edit existing students
- `delete_student.php`: Confirmation page to delete students
- `create_database.sql`: SQL script to set up the database

## Security Notes

- Passwords are hashed using bcrypt.
- All database queries use prepared statements to prevent SQL injection.
- Session-based authentication ensures only logged-in users can access the dashboard.

## Dark Mode

- Toggle between light and dark themes using the "Toggle Dark Mode" button in the navigation.
- Your preference is saved in localStorage and persists across sessions.

## Troubleshooting

- If database connection fails, check your MySQL credentials in `config.php`.
- Ensure the database `school_db` exists and tables are created.
- For Laragon users, start Apache and MySQL from the Laragon control panel.