<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Welcome to the Dashboard</h1>
    <p>This is the home page. Please select an option below:</p>
    <div class="button-group">
        <a href="logout.php" class="action-button">logout</a>
    </div>
</div>
</body>
</html>
