<?php
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hotel_id = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : 0;

$hotel_query = $mysqli->prepare('SELECT name, description FROM hotels WHERE id = ?');
$hotel_query->bind_param('i', $hotel_id);
$hotel_query->execute();
$hotel_result = $hotel_query->get_result();

if ($hotel = $hotel_result->fetch_assoc()) {
    echo '<h1>' . htmlspecialchars($hotel['name']) . '</h1>';
    echo '<p>' . htmlspecialchars($hotel['description']) . '</p>';
} else {
    echo '<p class="text-danger">Готель не знайдено.</p>';
}

$hotel_query->close();

$comments_query = $mysqli->prepare('SELECT user_name, comment, created_at FROM comments WHERE hotel_id = ? ORDER BY created_at DESC');
$comments_query->bind_param('i', $hotel_id);
$comments_query->execute();
$comments_result = $comments_query->get_result();

echo '<h2>Коментарі:</h2>';
if ($comments_result->num_rows > 0) {
    while ($comment = $comments_result->fetch_assoc()) {
        echo '<div class="comment">';
        echo '<h4>' . htmlspecialchars($comment['user_name']) . ' <small>(' . $comment['created_at'] . ')</small></h4>';
        echo '<p>' . htmlspecialchars($comment['comment']) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p>Коментарів поки немає.</p>';
}

$comments_query->close();
$mysqli->close();
?>
