<?php
if(!isset($_COOKIE['name']))
{
    setcookie("name", "Johnnie Walker", time()+60*60*24, "/","", 0);
    setcookie("volume", "1", time()+60*60*24, "/", "", 0);
}
else
{
    $_COOKIE['volume']=$_COOKIE['volume']+1;
    setcookie("volume", $_COOKIE['volume']);
}

echo 'Name:'.$_COOKIE['name'].'<br/>';
echo 'Volume:'.$_COOKIE['volume'].'<br/>';
?>
<a href="cookie.php">Increase</a>