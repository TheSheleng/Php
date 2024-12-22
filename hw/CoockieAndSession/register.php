<?php
session_start();
$usersFile = 'users.json';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $errors[] = 'Введите логин и пароль.';
    } else {
        $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

        if (isset($users[$username])) {
            $errors[] = 'Пользователь с таким именем уже существует.';
        } else {
            $users[$username] = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents($usersFile, json_encode($users));
            $_SESSION['username'] = $username;
            header('Location: moderate.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="tabs">
        <a href="login.php">SIGN IN</a>
        <a href="#" class="active">SIGN UP</a>
    </div>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">SIGN UP</button>
    </form>
</div>
</body>
</html>
