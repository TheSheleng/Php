<?php
include_once('pages/functions.php');

$mysqli = connect();

$ct1 = 'CREATE TABLE countries (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(64) UNIQUE
) DEFAULT CHARSET="utf8"';

$ct2 = 'CREATE TABLE cities (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(64),
    countryid INT,
    FOREIGN KEY(countryid) REFERENCES countries(id) ON DELETE CASCADE,
    ucity VARCHAR(128),
    UNIQUE INDEX ucity(city, countryid)
) DEFAULT CHARSET="utf8"';

$ct3 = 'CREATE TABLE hotels (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hotel VARCHAR(64),
    cityid INT,
    FOREIGN KEY(cityid) REFERENCES cities(id) ON DELETE CASCADE,
    countryid INT,
    FOREIGN KEY(countryid) REFERENCES countries(id) ON DELETE CASCADE,
    stars INT,
    cost INT,
    info VARCHAR(1024)
) DEFAULT CHARSET="utf8"';

$ct4 = 'CREATE TABLE images (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    imagepath VARCHAR(255),
    hotelid INT,
    FOREIGN KEY(hotelid) REFERENCES hotels(id) ON DELETE CASCADE
) DEFAULT CHARSET="utf8"';

$ct5 = 'CREATE TABLE roles (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(32)
) DEFAULT CHARSET="utf8"';

$ct6 = 'CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(32) UNIQUE,
    pass VARCHAR(128),
    email VARCHAR(128),
    discount INT,
    roleid INT,
    FOREIGN KEY(roleid) REFERENCES roles(id) ON DELETE CASCADE,
    avatar MEDIUMBLOB
) DEFAULT CHARSET="utf8"';

$ct7 = 'CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
) DEFAULT CHARSET="utf8"';

$queries = [$ct1, $ct2, $ct3, $ct4, $ct5, $ct6, $ct7];

foreach ($queries as $index => $query) {
    if (!$mysqli->query($query)) {
        echo 'Error code ' . ($index + 1) . ': ' . $mysqli->error . '<br>';
        exit();
    }
}

echo "Tables created successfully!";

$mysqli->close();
?>
