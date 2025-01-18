<?php
include_once('functions.php');
$link = connect(); // Подключение к базе данных

$ct1 = 'CREATE TABLE countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(64) UNIQUE
) DEFAULT CHARSET=utf8';

$ct2 = 'CREATE TABLE cities (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(64),
    countryid INT,
    FOREIGN KEY (countryid) REFERENCES countries(id) ON DELETE CASCADE,
    ucity VARCHAR(128),
    UNIQUE INDEX ucity (city, countryid)
) DEFAULT CHARSET=utf8';

$ct3 = 'CREATE TABLE hotels (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hotel VARCHAR(64),
    cityid INT,
    FOREIGN KEY (cityid) REFERENCES cities(id) ON DELETE CASCADE,
    countryid INT,
    FOREIGN KEY (countryid) REFERENCES countries(id) ON DELETE CASCADE,
    stars INT,
    cost INT,
    info VARCHAR(1024)
) DEFAULT CHARSET=utf8';

$ct4 = 'CREATE TABLE images (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    imagepath VARCHAR(255),
    hotelid INT,
    FOREIGN KEY (hotelid) REFERENCES hotels(id) ON DELETE CASCADE
) DEFAULT CHARSET=utf8';

$ct5 = 'CREATE TABLE roles (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(32)
) DEFAULT CHARSET=utf8';

$ct6 = 'CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(32) UNIQUE,
    pass VARCHAR(128),
    email VARCHAR(128),
    discount INT,
    roleid INT,
    FOREIGN KEY (roleid) REFERENCES roles(id) ON DELETE CASCADE,
    avatar MEDIUMBLOB
) DEFAULT CHARSET=utf8';

$ct7 = "INSERT INTO roles (id, role) VALUES (2, 'User')";

// Функция для выполнения запросов и проверки ошибок
function executeQuery($link, $query, $errorCode) {
    if (!mysqli_query($link, $query)) {
        echo "Error code $errorCode: " . mysqli_error($link) . "<br>";
        exit();
    }
}

// Выполнение запросов
executeQuery($link, $ct1, 1);
executeQuery($link, $ct2, 2);
executeQuery($link, $ct3, 3);
executeQuery($link, $ct4, 4);
executeQuery($link, $ct5, 5);
executeQuery($link, $ct6, 6);
executeQuery($link, $ct7, 7);

echo "All tables created successfully!";
