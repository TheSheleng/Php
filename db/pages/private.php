<?php
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo '<form action="index.php?page=5" method="post" enctype="multipart/form-data" class="input-group">';
echo '<select name="userid">';

$sel = 'SELECT * FROM users WHERE roleid = 2 ORDER BY login';
$res = $mysqli->query($sel);

if ($res) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['login']) . '</option>';
    }
    $res->free();
} else {
    echo "Ошибка при извлечении данных о пользователях.";
}

echo '</select>';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="500000" />';
echo '<input type="file" name="file" accept="image/*">';
echo '<input type="submit" name="addadmin" value="Add" class="btn btn-sm btn-info">';
echo '</form>';

if (isset($_POST['addadmin'])) {
    $userid = $_POST['userid'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fn = $_FILES['file']['tmp_name'];
        $file = fopen($fn, 'rb');
        $img = fread($file, filesize($fn));
        fclose($file);

        $img = $mysqli->real_escape_string($img);

        $stmt = $mysqli->prepare('UPDATE users SET avatar = ?, roleid = 1 WHERE id = ?');
        $stmt->bind_param('si', $img, $userid);

        if ($stmt->execute()) {
            echo "Пользователь успешно обновлен!";
        } else {
            echo "Ошибка при обновлении пользователя: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при загрузке файла.";
    }
}
$mysqli->close();
?>
