<?php
session_start();

$dsn =  "mysql:host=localhost;dbname=secure_app;charset=utf8mb4";

$username = "root";
$password = "";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    if (!$name || !$email || !$pass) {
        $error = "All fields are required.";
    } else {
        try {
            $pdo = new PDO($dsn, $username, $password, $options);
            $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $check->execute([$email]);

            if ($check->rowCount() > 0) {
                $error = "Email already exists.";
            } else {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $insert->execute([$name, $email, $hash]);
                $success = "Account created! <a href='login.php'>Login here</a>";
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: sans-serif;
        }
        .container {
            width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px #aaa;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .msg {
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
        }
        .error { background: #ffc9c9; }
        .success { background: #c9f7d4; }
        a { color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create Account</h2>
    
    <?php if ($error): ?>
        <div class="msg error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input name="name" placeholder="Full Name" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p style="margin-top:20px;">Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
