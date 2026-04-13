<?php
// add_student.php - Form to add a new student

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    // Validate input
    if (empty($name) || empty($email) || empty($course)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Insert student into database
        $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $course])) {
            $success = "Student added successfully.";
            // Clear form
            $name = $email = $course = '';
        } else {
            $error = "Failed to add student.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Record System</title>
    <style>
        :root {
            --bg-color: #f4f4f4;
            --text-color: #333;
            --nav-bg: #333;
            --nav-text: white;
            --container-bg: white;
            --input-border: #ccc;
            --btn-bg: #007bff;
            --alert-danger-bg: #f8d7da;
            --alert-danger-text: #721c24;
            --alert-danger-border: #f5c6cb;
            --alert-success-bg: #d4edda;
            --alert-success-text: #155724;
            --alert-success-border: #c3e6cb;
        }
        body.dark {
            --bg-color: #333;
            --text-color: #f4f4f4;
            --nav-bg: #222;
            --nav-text: #f4f4f4;
            --container-bg: #444;
            --input-border: #666;
            --btn-bg: #0056b3;
            --alert-danger-bg: #5a1a1a;
            --alert-danger-text: #f5c6cb;
            --alert-danger-border: #721c24;
            --alert-success-bg: #1a3a1a;
            --alert-success-text: #c3e6cb;
            --alert-success-border: #155724;
        }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: var(--bg-color); color: var(--text-color); display: flex; justify-content: center; align-items: center; height: 100vh; }
        nav { background: var(--nav-bg); color: var(--nav-text); padding: 10px; position: absolute; top: 0; width: 100%; display: flex; justify-content: space-between; }
        nav a { color: var(--nav-text); text-decoration: none; margin-left: 15px; }
        .container { background: var(--container-bg); padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; margin-top: 60px; }
        h3 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid var(--input-border); border-radius: 3px; background: var(--container-bg); color: var(--text-color); }
        button { width: 100%; padding: 10px; background: var(--btn-bg); color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { opacity: 0.8; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-danger { background: var(--alert-danger-bg); color: var(--alert-danger-text); border: 1px solid var(--alert-danger-border); }
        .alert-success { background: var(--alert-success-bg); color: var(--alert-success-text); border: 1px solid var(--alert-success-border); }
        #theme-toggle { background: var(--btn-bg); color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
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
        <h3>Add New Student</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($course ?? ''); ?>" required>
            </div>
            <button type="submit">Add Student</button>
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