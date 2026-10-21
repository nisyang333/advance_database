<?php
session_start();
require_once 'db.php';

$message = '';

if (isset($_GET['registered'])) {
    $message = '<div class="alert alert-success">Account created! You can now log in.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $message = '<div class="alert alert-success">Login successfully</div>';
            } else {
                $message = '<div class="alert alert-danger">Invalid username or password.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Invalid username or password.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-danger">Please fill in all fields.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-hero">
            <div class="auth-hero-content">
                <h1>Sign in to your<br><span>Adventure!</span></h1>
            </div>
        </div>
        <div class="auth-form-container">
            <h2>SIGN IN</h2>
            <?= $message; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-icon-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="text" name="username" id="username" placeholder="Enter your username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn">SIGN IN</button>
            </form>
            <div class="auth-link">
                Don't have an account? <a href="register.php">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>