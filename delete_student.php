<?php
// delete_student.php - Delete a student record

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
require_once 'config.php';

// Get student ID from URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    // Delete student from database
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        $error = "Failed to delete student.";
    }
}

// Fetch student data for confirmation
$stmt = $pdo->prepare("SELECT name FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - Student Record System</title>
    <style>
        :root {
            --bg-color: #f4f4f4;
            --text-color: #333;
            --nav-bg: #333;
            --nav-text: white;
            --container-bg: white;
            --btn-danger: #dc3545;
            --btn-secondary: #6c757d;
            --alert-danger-bg: #f8d7da;
            --alert-danger-text: #721c24;
            --alert-danger-border: #f5c6cb;
        }
        body.dark {
            --bg-color: #333;
            --text-color: #f4f4f4;
            --nav-bg: #222;
            --nav-text: #f4f4f4;
            --container-bg: #444;
            --btn-danger: #c82333;
            --btn-secondary: #5a6268;
            --alert-danger-bg: #5a1a1a;
            --alert-danger-text: #f5c6cb;
            --alert-danger-border: #721c24;
        }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: var(--bg-color); color: var(--text-color); display: flex; justify-content: center; align-items: center; height: 100vh; }
        nav { background: var(--nav-bg); color: var(--nav-text); padding: 10px; position: absolute; top: 0; width: 100%; display: flex; justify-content: space-between; }
        nav a { color: var(--nav-text); text-decoration: none; margin-left: 15px; }
        .container { background: var(--container-bg); padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; margin-top: 60px; }
        h3 { text-align: center; margin-bottom: 20px; }
        p { margin-bottom: 20px; }
        .text-danger { color: var(--btn-danger); }
        button, a { padding: 10px 15px; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn-danger { background: var(--btn-danger); color: white; }
        .btn-secondary { background: var(--btn-secondary); color: white; }
        button:hover, a:hover { opacity: 0.8; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-danger { background: var(--alert-danger-bg); color: var(--alert-danger-text); border: 1px solid var(--alert-danger-border); }
        #theme-toggle { background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        #theme-toggle:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <nav>
        <div>Student Record System</div>
        <div>
            <a href="dashboard.php">Back to Dashboard</a>
            <button id="theme-toggle">Toggle Dark Mode</button>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h3>Delete Student</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <p>Are you sure you want to delete the student "<strong><?php echo htmlspecialchars($student['name']); ?></strong>"?</p>
        <p class="text-danger">This action cannot be undone.</p>
        <form method="POST">
            <button type="submit" name="confirm_delete" class="btn-danger">Yes, Delete</button>
            <a href="dashboard.php" class="btn-secondary">Cancel</a>
        </form>
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