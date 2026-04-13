<?php
// dashboard.php - Main dashboard showing student records

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
require_once 'config.php';

// Fetch all students
$stmt = $pdo->query("SELECT * FROM students ORDER BY id ASC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Record System</title>
    <style>
        :root {
            --bg-color: #f4f4f4;
            --text-color: #333;
            --nav-bg: #333;
            --nav-text: white;
            --container-bg: white;
            --table-header-bg: #f8f8f8;
            --table-border: #ddd;
            --btn-primary: #007bff;
            --btn-success: #28a745;
            --btn-warning: #ffc107;
            --btn-danger: #dc3545;
            --alert-info-bg: #d1ecf1;
            --alert-info-text: #0c5460;
            --alert-info-border: #bee5eb;
        }
        body.dark {
            --bg-color: #333;
            --text-color: #f4f4f4;
            --nav-bg: #222;
            --nav-text: #f4f4f4;
            --container-bg: #444;
            --table-header-bg: #555;
            --table-border: #666;
            --btn-primary: #0056b3;
            --btn-success: #218838;
            --btn-warning: #e0a800;
            --btn-danger: #c82333;
            --alert-info-bg: #1a3a40;
            --alert-info-text: #bee5eb;
            --alert-info-border: #0c5460;
        }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: var(--bg-color); color: var(--text-color); }
        nav { background: var(--nav-bg); color: var(--nav-text); padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: var(--nav-text); text-decoration: none; margin-left: 15px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: var(--container-bg); border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
        .add-btn { background: var(--btn-success); color: white; padding: 10px 15px; text-decoration: none; border-radius: 3px; }
        .add-btn:hover { background: var(--btn-success); opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid var(--table-border); }
        th { background: var(--table-header-bg); }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; border: none; cursor: pointer; }
        .btn-warning { background: var(--btn-warning); }
        .btn-danger { background: var(--btn-danger); }
        .btn:hover { opacity: 0.8; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-info { background: var(--alert-info-bg); color: var(--alert-info-text); border: 1px solid var(--alert-info-border); }
        #theme-toggle { background: var(--btn-primary); color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        #theme-toggle:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <nav>
        <div>Student Record System</div>
        <div>
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            <button id="theme-toggle">Toggle Dark Mode</button>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Student Records</h2>
            <a href="add_student.php" class="add-btn">Add New Student</a>
        </div>

        <?php if (empty($students)): ?>
            <div class="alert alert-info">No students found. <a href="add_student.php">Add the first student</a>.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['course']); ?></td>
                            <td>
                                <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        const toggleButton = document.getElementById('theme-toggle');
        const body = document.body;

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark');
        }

        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark');
            localStorage.setItem('theme', body.classList.contains('dark') ? 'dark' : 'light');
        });
    </script>
</body>
</html>