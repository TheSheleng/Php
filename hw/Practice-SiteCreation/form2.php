<?php
if( !isset($_POST['submit']))
{
    ?>
    <form action="form2.php" method="POST">
        <p>Enter your name: <input type="text" name="username"></p>
        <p>Enter your password: <input type="password" name="userpass"></p>
        <p><input type="submit" name="submit" value="Login"></p>
    </form>
    <?php
}
else
{
    echo 'You are welcome, '.$_POST["username"].'! Your password is '.
        $_POST["userpass"].'<br/>';
}
?>
