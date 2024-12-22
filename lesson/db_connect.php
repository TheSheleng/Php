<?php
// Конфигурация подключения к базе данных
$servername = "localhost";     // Адрес сервера базы данных
$username = "root";            // Имя пользователя
$password = "1234";            // Пароль пользователя (по умолчанию пустой для XAMPP)
$dbname = "my_database_php";   // Имя базы данных

// Объектно-ориентированный стиль подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!<br>";

// SQL-запрос на создание таблицы (если не существует)
$sql_create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'users' created successfully!<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// SQL-запрос на вставку данных
$sql_insert = "INSERT INTO users (name, email) VALUES ('John Doe', 'johndoe@example.com')";
if ($conn->query($sql_insert) === TRUE) {
    echo "New record created successfully!<br>";
} else {
    echo "Error inserting record: " . $conn->error . "<br>";
}

// SQL-запрос на получение данных из таблицы
$sql_select = "SELECT id, name, email, created_at FROM users";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    // Вывод данных каждой строки
    echo "<h3>Users List:</h3>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . " - Created At: " . $row["created_at"] . "<br>";
    }
} else {
    echo "No records found.";
}

// Закрытие соединения
$conn->close();
?>
