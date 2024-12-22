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

        if (!isset($users[$username]) || !password_verify($password, $users[$username])) {
            $errors[] = 'Неверные логин или пароль.';
        } else {
            $_SESSION['username'] = $username;
            setcookie('username', $username, time() + 3600, '/'); // Cookie на 1 час
            header('Location: index.php');
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="tabs">
        <a href="#" class="active">SIGN IN</a>
        <a href="register.php">SIGN UP</a>
    </div>
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-check checkbox-container">
            <input type="checkbox" id="keepSignedIn" name="keepSignedIn">
            <label for="keepSignedIn">Keep Me Signed In</label>
        </div>
        <button type="submit">SIGN IN</button>
    </form>
</div>
</body>
</html>
