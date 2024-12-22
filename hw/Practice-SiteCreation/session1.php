<?php
session_start(); // Створення сесії або підключення до існуючої
echo 'id='.session_id().'</br>'; // Виведення ідентифікатора сесії

$_SESSION['num'] = 100; // Занесення значення в сесію
echo 'From first file num = '.$_SESSION['num'].'<br/>';
?>
<a href='session2.php'>Forward</a>
