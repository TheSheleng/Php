<?php
session_start(); // Підключення до існуючої сесії
echo 'id='.session_id().'</br>'; // Виведення ідентифікатора сесії

echo 'From second file num='.$_SESSION['num'].'<br/>'; // Виведення значення з сесії
?>
<a href='session1.php'>Back</a>
