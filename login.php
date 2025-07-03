<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$dsn = $dsn = "mysql:host=localhost;dbname=secure_app;charset=utf8mb4";
$username = "root";
$password = "";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    try {
        $pdo = new PDO($dsn, $username, $password, $options);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background-color: #e0f7fa;
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
            background-color: #007bff;
            color: white;
            border: none;
        }
        .msg {
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
        }
        .error { background: #ffc9c9; }
        a { color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="msg error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p style="margin-top:20px;">New user? <a href="create.php">Register here</a></p>
</div>
</body>
</html>
