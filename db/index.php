<?php
session_start();
include_once ("pages/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Travel Agency</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/style1.css" rel="stylesheet">
    </head>

    <body>
        <div class="container" >
            <div class="row">
                <header class="col-sm-12 col-md-12 col-lg-12">
                    <?php include_once("pages/login.php");?>
                </header>
            </div>
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
                    if(isset($_GET['page']))  {
                        $page = $_GET['page'];
                        if($page == 1) include_once("pages/tours.php");
                        if($page == 2) include_once("pages/comments.php");
                        if($page == 3) include_once("pages/registration.php");
                        if($page == 4) include_once("pages/admin.php");
                    }
                    ?>
                </section>
            </div>
            <div class="row">
                <footer>Step Academy &copy;</footer>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>