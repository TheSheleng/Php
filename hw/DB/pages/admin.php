<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <?php
            $mysqli = connect();
            $sel = 'SELECT * FROM countries';
            $res = $mysqli->query($sel);

            if (!$res) {
                die("Query failed: " . $mysqli->error);
            }

            echo '<form action="index.php?page=4" method="post" class="input-group" id="formcountry">';
            echo '<table class="table table-striped">';

            while ($row = $res->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>'; // Замените 'id' на имя столбца в вашей таблице
                echo '<td>' . htmlspecialchars($row['country']) . '</td>'; // Замените 'name' на имя столбца в вашей таблице
                echo '<td><input type="checkbox" name="cb' . htmlspecialchars($row['id']) . '"></td>';
                echo '</tr>';
            }

            echo '</table>';
            $res->free();

            echo '<input type="text" name="country" placeholder="Country" class="form-control">';
            echo '<input type="submit" name="addcountry" value="Add" class="btn btn-sm btn-info">';
            echo '<input type="submit" name="delcountry" value="Delete" class="btn btn-sm btn-warning">';
            echo '</form>';

            $mysqli->close();
        ?>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 right">
        <?php
        $mysqli = connect(); // Функция подключения к базе данных

        // Начало формы
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcity">';

        // Запрос для получения данных о городах и странах
        $sel = 'SELECT ci.id, ci.city, co.country
        FROM countries co
        JOIN cities ci ON ci.countryid = co.id';
        $res = $mysqli->query($sel);

        echo '<table class="table table-striped">';
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['city']) . '</td>';
            echo '<td>' . htmlspecialchars($row['country']) . '</td>';
            echo '<td><input type="checkbox" name="ci' . htmlspecialchars($row['id']) . '"></td>';
            echo '</tr>';
        }
        echo '</table>';
        $res->free();

        // Запрос для получения списка стран для выпадающего списка
        $res = $mysqli->query('SELECT * FROM countries');
        echo '<select name="countryname" class="form-control">';
        while ($row = $res->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['country']) . '</option>';
        }
        echo '</select>';

        // Поле для ввода города
        echo '<input type="text" name="city" placeholder="City" class="form-control">';

        // Кнопки для добавления и удаления города
        echo '<input type="submit" name="addcity" value="Add" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delcity" value="Delete" class="btn btn-sm btn-warning">';

        // Закрытие формы
        echo '</form>';

        $mysqli->close(); // Закрытие соединения с базой данных
        ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class=" col-sm-6 col-md-6 col-lg-6 left ">
        <?php
        $mysqli = connect(); // Функция подключения к базе данных

        // Начало формы
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formhotel">';

        // Запрос для получения данных о городах, отелях и странах
        $sel = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country
        FROM cities ci
        JOIN hotels ho ON ho.cityid = ci.id
        JOIN countries co ON ho.countryid = co.id';
        $res = $mysqli->query($sel);

        echo '<table class="table" width="100%">';
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['city']) . " - " . htmlspecialchars($row['country']) . '</td>';
            echo '<td>' . htmlspecialchars($row['hotel']) . '</td>';
            echo '<td>' . htmlspecialchars($row['stars']) . '</td>';
            echo '<td><input type="checkbox" name="hb' . htmlspecialchars($row['id']) . '"></td>';
            echo '</tr>';
        }
        echo '</table>';

        // Освобождение результата после обработки
        $res->free();

        // Запрос для получения списка городов и стран
        $sel = 'SELECT ci.id, ci.city, co.country, co.id AS country_id
        FROM countries co
        JOIN cities ci ON ci.countryid = co.id';
        $res = $mysqli->query($sel);

        $csel = array();
        echo '<select name="hcity" class="">';
        while ($row = $res->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['city']) . " : " . htmlspecialchars($row['country']) . '</option>';
            $csel[$row['id']] = $row['id'];
        }
        echo '</select>';

        // Вводные поля для добавления отеля
        echo '<input type="text" name="hotel" placeholder="Hotel" class="form-control">';
        echo '<input type="text" name="cost" placeholder="Cost" class="form-control">';
        echo 'Stars: <input type="number" name="stars" min="1" max="5" class="form-control"><br>';
        echo '<textarea name="info" placeholder="Description" class="form-control"></textarea><br>';

        // Кнопки для добавления и удаления отелей
        echo '<input type="submit" name="addhotel" value="Добавить" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delhotel" value="Удалить" class="btn btn-sm btn-warning">';

        // Закрытие формы
        echo '</form>';

        // Освобождение результата
        $res->free();

        // Закрытие соединения с базой данных
        $mysqli->close();
        ?>
    </div>
    <div class=" col-sm-6 col-md-6 col-lg-6 right ">
        <!-- section D: for form Images -->
    </div>
</div>

<?php
$mysqli = connect(); // Функция подключения к базе данных

// Обработка добавления страны
if (isset($_POST['addcountry'])) {
    $country = trim(htmlspecialchars($_POST['country']));
    if ($country == "") exit();

    // Подготовленное выражение для добавления данных
    $stmt = $mysqli->prepare('INSERT INTO countries (country) VALUES (?)');
    $stmt->bind_param('s', $country); // 's' - строковый тип
    $stmt->execute();
    $stmt->close();

    // Перезагрузка страницы
    echo "<script>";
    echo "window.location=document.URL;";
    echo "</script>";
}

// Обработка удаления стран
if (isset($_POST['delcountry'])) {
    foreach ($_POST as $k => $v) {
        if (substr($k, 0, 2) == "cb") {
            $idc = substr($k, 2);

            // Подготовленное выражение для удаления данных
            $stmt = $mysqli->prepare('DELETE FROM countries WHERE id = ?');
            $stmt->bind_param('i', $idc); // 'i' - целочисленный тип
            $stmt->execute();
            $stmt->close();
        }
    }

    // Перезагрузка страницы
    echo "<script>";
    echo "window.location=document.URL;";
    echo "</script>";
}

// Обработка добавления города
if (isset($_POST['addcity'])) {
    $city = trim(htmlspecialchars($_POST['city']));
    if ($city == "") exit();
    $countryid = $_POST['countryname'];

    // Подготовленное выражение для добавления города
    $stmt = $mysqli->prepare('INSERT INTO cities (city, countryid) VALUES (?, ?)');
    $stmt->bind_param('si', $city, $countryid); // 's' - строка, 'i' - целое число
    $stmt->execute();

    // Проверка на ошибки
    if ($stmt->error) {
        echo 'Error code: ' . $stmt->errno . '<br>';
        echo 'Error message: ' . $stmt->error . '<br>';
        exit();
    }

    $stmt->close();

    // Перезагрузка страницы
    echo "<script>";
    echo "window.location=document.URL;";
    echo "</script>";
}

// Обработка удаления города
if (isset($_POST['delcity'])) {
    foreach ($_POST as $k => $v) {
        if (substr($k, 0, 2) == "ci") {
            $idc = substr($k, 2);

            // Подготовленное выражение для удаления города
            $stmt = $mysqli->prepare('DELETE FROM cities WHERE id = ?');
            $stmt->bind_param('i', $idc); // 'i' - целое число
            $stmt->execute();
            $stmt->close();
        }
    }

    // Перезагрузка страницы
    echo "<script>";
    echo "window.location=document.URL;";
    echo "</script>";
}

if (isset($_POST['addhotel'])) {
    $hotel = trim(htmlspecialchars($_POST['hotel']));
    $cost = intval(trim(htmlspecialchars($_POST['cost'])));
    $stars = intval($_POST['stars']);
    $info = trim(htmlspecialchars($_POST['info']));

    // Проверка на пустые поля
    if ($hotel == "" || $cost == "" || $stars == "") exit();

    $cityid = $_POST['hcity'];

    $query = "
        SELECT co.id
        FROM countries co
        JOIN cities ci ON ci.countryid = co.id
        WHERE ci.id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $cityid);
    $stmt->execute();

    $stmt->bind_result($countryid); // Переменная для хранения страны
    $stmt->fetch();

    // Подготовка SQL-запроса

    $mysqli->close();
    $mysqli = connect();

    $ins = $mysqli->prepare('INSERT INTO hotels (hotel, cityid, countryid, stars, cost, info) 
        VALUES (?, ?, ?, ?, ?, ?)');
    $ins->bind_param('siisis', $hotel, $cityid, $countryid, $stars, $cost, $info);
    if ($ins->execute()) {
        echo "<script>";
        echo "window.location=document.URL;";
        echo "</script>";
    } else {
        echo 'Ошибка добавления отеля: ' . $ins->error;
    }

    // Закрытие подготовленного выражения
    $ins->close();
}

if (isset($_POST['delhotel'])) {
    foreach ($_POST as $k => $v) {
        if (substr($k, 0, 2) == "hb") {
            $idc = substr($k, 2);

            // Подготовка и выполнение удаления
            $del = $mysqli->prepare('DELETE FROM hotels WHERE id = ?');
            $del->bind_param('i', $idc);

            if ($del->execute()) {
                // Успешно удалено
            } else {
                echo 'Ошибка удаления отеля: ' . $del->error;
            }

            // Закрытие подготовленного выражения
            $del->close();
        }
    }

    echo "<script>";
    echo "window.location=document.URL;";
    echo "</script>";
}

// Закрытие соединения с базой данных
$mysqli->close();


