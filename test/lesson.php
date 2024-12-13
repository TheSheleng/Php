<?php
$str = 'banana lemon 223orange';
$arr = preg_split('/\d|\s|_/', $str);
var_dump($arr);

if (!empty($_GET['login'])) {
    echo 'Hello ' . $_GET['login'];
    setcookie('login', $_GET['login']);
}
?>

<form>
    <input type="text" name="login">
    <button type="submit">Send</button>
</form>
