<h2>Select Tours</h2>
<hr>
<?php
$mysqli = connect();
echo '<form action="index.php?page=1" method="post">';
echo '<select name="countryid" class="col-sm-3 col-md-3 col-lg-3">';

$res = $mysqli->query("SELECT * FROM countries ORDER BY country");
echo '<option value="0">Select country...</option>';

while ($row = $res->fetch_array(MYSQLI_NUM)) {
    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
}

$res->free_result();
echo '<input type="submit" name="selcountry" value="Select Country" class="btn btn-xs btn-primary">';
echo '</select>';
$mysqli->close();

if (isset($_POST['selcountry'])) {
    echo '<br/>';
    $countryid = $_POST['countryid'];
    if ($countryid == 0) exit();

    $mysqli = connect();
    $result = $mysqli->query("SELECT * FROM cities WHERE countryid = $countryid ORDER BY city");

    echo '<select name="cityid" class="col-sm-3 col-md-3 col-lg-3">';
    echo '<option value="0">Select city...</option>';

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    }

    $result->free_result();
    echo '</select>';
    echo '<input type="submit" name="selcity" value="Select City" class="btn btn-xs btn-primary">';
    $mysqli->close();
}

if (isset($_POST['selcity'])) {
    $cityid = $_POST['cityid'];
    $mysqli = connect();

    $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id
            FROM hotels ho
            JOIN cities ci ON ho.cityid = ci.id
            JOIN countries co ON ho.countryid = co.id
            WHERE ho.cityid = ?';

    if ($stmt = $mysqli->prepare($sel)) {
        $stmt->bind_param("i", $cityid); // связываем параметр $cityid как integer
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table width="100%" class="table table-striped tbtours text-center">';
        echo '<thead style="font-weight: bold">
                <td>Hotel</td><td>Country</td><td>City</td>
                <td>Price</td><td>Stars</td><td>link</td></thead>';

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            echo '<tr id="' . $row[1] . '">';
            echo '<td>' . htmlspecialchars($row[2]) . '</td> 
                  <td>' . htmlspecialchars($row[0]) . '</td> 
                  <td>' . htmlspecialchars($row[1]) . '</td>
                  <td>$' . htmlspecialchars($row[3]) . '</td>
                  <td>' . htmlspecialchars($row[4]) . '</td>
                  <td><a href="pages/hotelinfo.php?hotel=' . $row[5] . '" target="_blank"> more info</a></td>';
            echo '</tr>';
        }
        echo '</table><br>';
        $stmt->close();
    } else {
        echo "Error in query preparation: " . $mysqli->error;
    }
    $mysqli->close();
}
?>
