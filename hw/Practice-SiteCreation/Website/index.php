<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <?php
                include_once('pages/menu.php');
                include_once('pages/functions.php');
            ?>

        </nav>
    </div>

    <div class="row">
        <section class="col-sm-12 col-md-12 col-lg-12">
            <?php
            if(isset($_GET['page']))
            {
                $page = $_GET['page'];
                switch ($page) {
                    case 'home': include_once('pages/home.php'); break;
                    case 'upload': include_once('pages/upload.php'); break;
                    case 'gallery': include_once('pages/gallery.php'); break;
                    case 'registration': include_once('pages/registration.php'); break;
                }
            }
            ?>
        </section>
    </div>

    <div class="row">
        <header class="col-sm-12 col-md-12 col-lg-12"></header>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if (isset($_POST['loginbtn'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (login($login, $password)) {
        // Успішний вхід
        echo "<script>window.location = 'moderate.php?page=home';</script>"; // Перехід на домашню сторінку
    } else {
        // Якщо не вдалося увійти
        echo "<h3/><span style='color:red;'>Invalid login or password!</span><h3/>";
    }
}
?>
