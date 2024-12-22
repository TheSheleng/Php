<?php
session_start();
session_destroy();
setcookie('username', '', time() - 3600, '/'); // Удаление Cookie
header('Location: login.php');
exit;
?>
