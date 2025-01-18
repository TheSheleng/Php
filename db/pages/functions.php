<?php
function connect() {
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "travels";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function register($name, $pass, $email) {
    $name = trim(htmlspecialchars($name));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));

    if ($name == "" || $pass == "" || $email == "") {
        echo "<h3/><span style='color:red;'>Fill All Required Fields!</span><h3/>";
        return false;
    }

    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Values Length Must Be Between 3 And 30!</span><h3/>";
        return false;
    }
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT);

    $mysqli = connect(); // Предполагаем, что функция connect() уже возвращает объект mysqli
    $stmt = $mysqli->prepare('INSERT INTO users (login, pass, email, roleid) VALUES (?, ?, ?, 2)');

    if (!$stmt) {
        echo "<h3/><span style='color:red;'>Failed to prepare statement!</span><h3/>";
        return false;
    }

    $stmt->bind_param('sss', $name, $hashedPass, $email);

    if ($stmt->execute()) {
        echo "<h3/><span style='color:green;'>Registration Successful!</span><h3/>";
        $stmt->close();
        $mysqli->close();
        return true;
    } else {
        if ($stmt->errno == 1062) {
            echo "<h3/><span style='color:red;'>This Login Is Already Taken!</span><h3/>";
        } else {
            echo "<h3/><span style='color:red;'>Error code: " . $stmt->errno . "!</span><h3/>";
        }
        $stmt->close();
        $mysqli->close();
        return false;
    }
}

function login($name, $pass) {
    $name = trim(htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
    $pass = trim(htmlspecialchars($pass, ENT_QUOTES, 'UTF-8'));

    if ($name == "" || $pass == "") {
        echo "<h3/><span style='color:red;'>Fill All Required Fields!</span><h3/>";
        return false;
    }
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Value Length Must Be Between 3 And 30!</span><h3/>";
        return false;
    }
    $mysqli = connect();

    $sel = 'SELECT * FROM users WHERE login = ?';
    if ($stmt = $mysqli->prepare($sel)) {
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            if (password_verify($pass, $row['pass'])) {
                $_SESSION['ruser'] = $name;
                if ($row['admin'] == 1) {
                    $_SESSION['radmin'] = $name;
                }
                $stmt->close();
                $mysqli->close();
                return true;
            } else {
                echo "<h3/><span style='color:red;'>Incorrect Password!</span><h3/>";
            }
        } else {
            echo "<h3/><span style='color:red;'>No Such User!</span><h3/>";
        }
        $stmt->close();
        $mysqli->close();
    } else {
        echo "<h3/><span style='color:red;'>Database Error: " . $mysqli->error . "</span><h3/>";
        $mysqli->close();
    }
    return false;
}

