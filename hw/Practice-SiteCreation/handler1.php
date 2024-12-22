<?php
if (isset($_POST["submit"])) {
    echo 'Вітаємо, ' . htmlspecialchars($_POST["username"]) .
        '! Ваш пароль: ' . htmlspecialchars($_POST["userpass"]) . '<br/>';
} else {
    echo 'Дані не були надані!<br/>';
}
?>
