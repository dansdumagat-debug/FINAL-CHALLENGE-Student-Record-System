<?php
// login.php - Login page for the Student Record System

session_start();

// Include database configuration
require_once 'config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Prepare and execute query to check user
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Record System</title>
    <style>
        :root {
            --bg-color: #f4f4f4;
            --text-color: #333;
            --container-bg: white;
            --input-border: #ccc;
            --btn-bg: #007bff;
            --alert-danger-bg: #f8d7da;
            --alert-danger-text: #721c24;
            --alert-danger-border: #f5c6cb;
        }
        body.dark {
            --bg-color: #333;
            --text-color: #f4f4f4;
            --container-bg: #444;
            --input-border: #666;
            --btn-bg: #0056b3;
            --alert-danger-bg: #5a1a1a;
            --alert-danger-text: #f5c6cb;
            --alert-danger-border: #721c24;
        }
        body { font-family: Arial, sans-serif; background-color: var(--bg-color); color: var(--text-color); margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: var(--container-bg); padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        h3 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid var(--input-border); border-radius: 3px; background: var(--container-bg); color: var(--text-color); }
        button { width: 100%; padding: 10px; background: var(--btn-bg); color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { opacity: 0.8; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-danger { background: var(--alert-danger-bg); color: var(--alert-danger-text); border: 1px solid var(--alert-danger-border); }
        #theme-toggle { position: absolute; top: 10px; right: 10px; background: var(--btn-bg); color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
        #theme-toggle:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <button id="theme-toggle">Toggle Dark Mode</button>
    <div class="container">
        <h3>Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
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