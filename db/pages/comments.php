<?php
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo '<form action="comments.php" method="post" class="input-group">';
echo '<select name="hotel_id" class="form-select">';

$sel = 'SELECT id, name FROM hotels ORDER BY name';
$res = $mysqli->query($sel);

if ($res) {
    while ($row = $res->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
    }
    $res->free();
} else {
    echo '<option disabled>Помилка завантаження готелів</option>';
}

echo '</select>';
echo '<input type="text" name="user_name" placeholder="Ваше ім’я" class="form-control" required>';
echo '<textarea name="comment" placeholder="Ваш коментар" class="form-control" required></textarea>';
echo '<button type="submit" name="submit_comment" class="btn btn-primary">Додати коментар</button>';
echo '</form>';

if (isset($_POST['submit_comment'])) {
    $hotel_id = $_POST['hotel_id'];
    $user_name = $mysqli->real_escape_string($_POST['user_name']);
    $comment = $mysqli->real_escape_string($_POST['comment']);

    $stmt = $mysqli->prepare('INSERT INTO comments (hotel_id, user_name, comment) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $hotel_id, $user_name, $comment);

    if ($stmt->execute()) {
        echo '<p class="text-success">Коментар успішно додано!</p>';
    } else {
        echo '<p class="text-danger">Помилка: ' . $stmt->error . '</p>';
    }
    $stmt->close();
}
$mysqli->close();
?>
