<?php

function connect(
    $host='localhost',
    $user='root',
    $pass='1234',
    $dbname='my_database_php')
{
    $link = mysqli_connect($host, $user, $pass, $dbname);
    if (!$link) {
        die('Connection error: ' . mysqli_connect_error());
    }
    if (!mysqli_set_charset($link, 'utf8')) {
        die('Error loading character set utf8: ' . mysqli_error($link));
    }
    return $link;
}

function register($name, $pass, $email) {
    // Очистка входных данных
    $name = trim(htmlspecialchars($name));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));

    // Проверка на пустые поля
    if (empty($name) || empty($pass) || empty($email)) {
        echo "<h3><span style='color:red;'>Fill All Required Fields!</span></h3>";
        return false;
    }

    // Проверка длины значений
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3><span style='color:red;'>Values Length Must Be Between 3 And 30!</span></h3>";
        return false;
    }

    // Подключение к базе данных
    $conn = new mysqli('localhost', 'root', '1234', 'my_database_php');
    if ($conn->connect_error) {
        die("<h3><span style='color:red;'>Connection Error: " . $conn->connect_error . "</span></h3>");
    }

    // Подготовка запроса
    $stmt = $conn->prepare('INSERT INTO users (login, pass, email, roleid) VALUES (?, ?, ?, ?)');
    if (!$stmt) {
        echo "<h3><span style='color:red;'>SQL Error: " . $conn->error . "</span></h3>";
        return false;
    }

    // Хеширование пароля
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
    $roleid = 2;

    // Связывание параметров
    $stmt->bind_param('sssi', $name, $hashedPass, $email, $roleid);

    // Выполнение запроса
    if (!$stmt->execute()) {
        if ($stmt->errno == 1062) {
            echo "<h3><span style='color:red;'>This Login Is Already Taken!</span></h3>";
        } else {
            echo "<h3><span style='color:red;'>Error Code: " . $stmt->errno . "</span></h3>";
        }
        return false;
    }

    // Закрытие соединения
    $stmt->close();
    $conn->close();

    return true;
}
