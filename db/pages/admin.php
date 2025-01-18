<?php
//    if (!isset($_SESSION['radmin'])) {
//        echo "<h3/><span style='color:red;'>For Administrators Only!</span><h3/>";
//        exit();
//    }
//?>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <?php
            $mysqli = connect();
            $sel = 'SELECT * FROM countries';
            $res = $mysqli->query($sel);

            if (!$res) {
                echo "<h3/><span style='color:red;'>Error: " . $mysqli->error . "</span><h3/>";
                exit();
            }

            echo '<form action="index.php?page=4" method="post" class="input-group" id="formcountry">';
            echo '<table class="table table-striped">';

            while ($row = $res->fetch_array(MYSQLI_NUM)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row[0]) . '</td>';
                echo '<td>' . htmlspecialchars($row[1]) . '</td>';
                echo '<td><input type="checkbox" name="cb' . $row[0] . '"></td>';
                echo '</tr>';
            }

            echo '</table>';
            $res->free_result();

            echo '<input type="text" name="country" placeholder="Country" class="form-control">';

            echo '<input type="submit" name="addcountry" value="Add" class="btn btn-sm btn-info">';
            echo '<input type="submit" name="delcountry" value="Delete" class="btn btn-sm btn-warning">';

            echo '</form>';
            $mysqli->close();

            if (isset($_POST['addcountry'])) {
                $country = trim(htmlspecialchars($_POST['country']));

                if ($country == "") exit();

                $mysqli = connect();
                $stmt = $mysqli->prepare('INSERT INTO countries (country) VALUES (?)');

                if (!$stmt) {
                    echo "<h3/><span style='color:red;'>Failed to prepare statement!</span><h3/>";
                    exit();
                }
                $stmt->bind_param('s', $country);

                if ($stmt->execute()) {
                    echo "<script>";
                    echo "window.location=document.URL;";
                    echo "</script>";
                } else {
                    echo "<h3/><span style='color:red;'>Error: " . $stmt->error . "</span><h3/>";
                }
                $stmt->close();
                $mysqli->close();
            }

            if (isset($_POST['delcountry'])) {
                $mysqli = connect();

                foreach ($_POST as $k => $v) {
                    if (substr($k, 0, 2) == "cb") {
                        $idc = substr($k, 2);

                        $stmt = $mysqli->prepare('DELETE FROM countries WHERE id = ?');

                        if (!$stmt) {
                            echo "<h3/><span style='color:red;'>Failed to prepare statement!</span><h3/>";
                            exit();
                        }
                        $stmt->bind_param('i', $idc);

                        if ($stmt->execute()) {
                            continue;
                        } else {
                            echo "<h3/><span style='color:red;'>Error: " . $stmt->error . "</span><h3/>";
                        }
                        $stmt->close();
                    }
                }
                $mysqli->close();

                echo "<script>";
                echo "window.location=document.URL;";
                echo "</script>";
            }
        ?>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6 right">
        <?php
        $mysqli = connect();
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formcity">';

        $sel = 'SELECT ci.id, ci.city, co.country FROM countries co, cities ci WHERE ci.countryid=co.id';
        $res = $mysqli->query($sel);

        echo '<table class="table table-striped">';
        while ($row = $res->fetch_array(MYSQLI_NUM)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row[0]) . '</td>';
            echo '<td>' . htmlspecialchars($row[1]) . '</td>';
            echo '<td>' . htmlspecialchars($row[2]) . '</td>';
            echo '<td><input type="checkbox" name="ci' . $row[0] . '"></td>';
            echo '</tr>';
        }
        echo '</table>';
        $res->free_result();

        $res = $mysqli->query('SELECT * FROM countries');
        echo '<select name="countryname" class="form-control">';
        while ($row = $res->fetch_array(MYSQLI_NUM)) {
            echo '<option value="' . $row[0] . '">' . htmlspecialchars($row[1]) . '</option>';
        }
        echo '</select>';

        echo '<input type="text" name="city" placeholder="City">';
        echo '<input type="submit" name="addcity" value="Add" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delcity" value="Delete" class="btn btn-sm btn-warning">';
        echo '</form>';
        $mysqli->close();

        $mysqli = connect();
        if (isset($_POST['addcity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            if ($city != "") {
                $countryid = $_POST['countryname'];
                $stmt = $mysqli->prepare('INSERT INTO cities (city, countryid) VALUES (?, ?)');
                $stmt->bind_param('si', $city, $countryid);
                $stmt->execute();
                $stmt->close();
                echo "<script>window.location=document.URL;</script>";
            }
        }

        if (isset($_POST['delcity'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "ci") {
                    $idc = substr($k, 2);
                    $stmt = $mysqli->prepare('DELETE FROM cities WHERE id = ?');
                    $stmt->bind_param('i', $idc);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            echo "<script>window.location=document.URL;</script>";
        }
        $mysqli->close();
        ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class=" col-sm-6 col-md-6 col-lg-6 left ">
        <?php
        $mysqli = connect();
        echo '<form action="index.php?page=4" method="post" class="input-group" id="formhotel">';
        $sel = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country
        FROM cities ci, hotels ho, countries co
        WHERE ho.cityid = ci.id AND ho.countryid = co.id';
        $res = $mysqli->query($sel);

        echo '<table class="table" width="100%">';
        while ($row = $res->fetch_array(MYSQLI_NUM)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row[2]) . '</td>';
            echo '<td>' . htmlspecialchars($row[1]) . " - " . htmlspecialchars($row[9]) . '</td>';
            echo '<td>' . htmlspecialchars($row[3]) . '</td>';
            echo '<td>' . htmlspecialchars($row[6]) . '</td>';
            echo '<td><input type="checkbox" name="hb' . $row[2] . '"></td>';
            echo '</tr>';
        }
        echo '</table>';
        $res->free_result();

        $sel = 'SELECT ci.id, ci.city, co.country, co.id FROM countries co, cities ci WHERE ci.countryid = co.id';
        $res = $mysqli->query($sel);

        echo '<select name="hcity" class="">';
        while ($row = $res->fetch_array(MYSQLI_NUM)) {
            echo '<option value="' . $row[0] . '">' . htmlspecialchars($row[1]) . " : " . htmlspecialchars($row[2]) . '</option>';
        }
        echo '</select>';

        echo '<input type="text" name="hotel" placeholder="Hotel">';
        echo '<input type="text" name="cost" placeholder="Cost">';
        echo '&nbsp;&nbsp;Stars: <input type="number" name="stars" min="1" max="5"><br>';
        echo '<textarea name="info" placeholder="Description"></textarea><br>';
        echo '<input type="submit" name="addhotel" value="Add" class="btn btn-sm btn-info">';
        echo '<input type="submit" name="delhotel" value="Delete" class="btn btn-sm btn-warning">';
        echo '</form>';
        $res->free_result();
        $mysqli->close();


        $mysqli = connect();

        if (isset($_POST['addhotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $cost = intval(trim(htmlspecialchars($_POST['cost'])));
            $stars = intval($_POST['stars']);
            $info = trim(htmlspecialchars($_POST['info']));

            if ($hotel == "" || $cost == "" || $stars == "") exit();

            $cityid = $_POST['hcity'];
            $countryid = $sel[$cityid];

            $stmt = $mysqli->prepare('INSERT INTO hotels (hotel, cityid, countryid, stars, cost, info) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('siisis', $hotel, $cityid, $countryid, $stars, $cost, $info);
            $stmt->execute();
            $stmt->close();
            echo "<script>window.location=document.URL;</script>";
        }

        if (isset($_POST['delhotel'])) {
            foreach ($_POST as $k => $v) {
                if (substr($k, 0, 2) == "hb") {
                    $idc = substr($k, 2);
                    $stmt = $mysqli->prepare('DELETE FROM hotels WHERE id = ?');
                    $stmt->bind_param('i', $idc);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            echo "<script>window.location=document.URL;</script>";
        }
        $mysqli->close();
        ?>

    </div>
    <div class=" col-sm-6 col-md-6 col-lg-6 right ">
        <?php
        $mysqli = connect();

        echo '<form action="index.php?page=4" method="post" enctype="multipart/form-data" class="input-group">';
        echo '<select name="hotelid">';

        $sel = 'SELECT ho.id, co.country, ci.city, ho.hotel 
        FROM countries co, cities ci, hotels ho 
        WHERE co.id = ho.countryid AND ci.id = ho.cityid 
        ORDER BY co.country';
        $res = $mysqli->query($sel);

        while ($row = $res->fetch_array(MYSQLI_NUM)) {
            echo '<option value="' . $row[0] . '">';
            echo $row[1] . ' ' . $row[2] . ' ' . $row[3] . '</option>';
        }

        $res->free_result();

        echo '</select>';
        echo '<input type="file" name="file[]" multiple accept="image/*">';
        echo '<input type="submit" name="addimage" value="Add" class="btn btn-sm btn-info">';
        echo '</form>';

        if (isset($_REQUEST['addimage'])) {
            foreach ($_FILES['file']['name'] as $k => $v) {
                if ($_FILES['file']['error'][$k] != 0) {
                    echo '<script>alert("Upload file error: ' . $v . '")</script>';
                    continue;
                }
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $fileExt = strtolower(pathinfo($v, PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExtensions)) {
                    echo '<script>alert("Invalid file type: ' . $v . '")</script>';
                    continue;
                }

                $uploadPath = 'images/' . basename($v);

                if (move_uploaded_file($_FILES['file']['tmp_name'][$k], $uploadPath)) {
                    $hotelid = $_REQUEST['hotelid'];
                    $stmt = $mysqli->prepare('INSERT INTO images (hotelid, imagepath) VALUES (?, ?)');
                    $stmt->bind_param('is', $hotelid, $uploadPath);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
        $mysqli->close();
        ?>

    </div>
</div>
