<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            background-color: #fff8e1;
            font-family: sans-serif;
            text-align: center;
            padding-top: 80px;
        }
        .box {
            background: #fff;
            padding: 30px;
            width: 400px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 12px #aaa;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            background: #ff5252;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h2>
    <p>You are now logged in.</p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
