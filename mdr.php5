﻿<!DOCTYPE html>
<html>

<head>
    <meta charset=UTF-8">
    <link rel="stylesheet" href="mdr.css">
    <title>mdr</title>
</head>
</html>

<?php
////////* Session Control *////////
session_start();

if( isset($_SESSION['login']) === false )
{
    $_SESSION['login'] = -1;
}
$login = $_SESSION['login'];

if( isset($_SESSION['username']) === false )
{
    $_SESSION['username'] = "";
}
$username = $_SESSION['username'];

if( isset($_SESSION['password']) === false )
{
    $_SESSION['password'] = "";
}
$password = $_SESSION['password'];
?>

<?php
////////* Get username and password with POST *////////
if( isset($_POST['submit']) === true && $login === -1)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    if ($username === 'root' && $password === 'masoudsam')
    {
        $_SESSION['login'] = 1;
        $login = 1;
    }
    else
    {
        echo '<h2>try again</h2>';
    }
}
?>

<?php
if ( $login === -1)
{
    echo "
        <body>

            <form method=\"post\" action=\"mdr.php5\">
                <h2>Username : <input type=\"text\" name=\"username\" value=\"$username\"></h2>
                <h2>Password :&nbsp; <input type=\"password\" name=\"password\" value=\"$password\"> </h2>
                <input type=\"submit\" name=\"submit\" value=\"admin\">
            </form>

            <a href=\"mdr.php5\" id=\"oo\" onclick=\"mdr.php?oo=true\">test</a>

        </body>
        ";
}
?>

<?php
////////* Functions *////////
function dirlist($dirpath = '.')
{
    $dirarray = scandir($dirpath);
    foreach ($dirarray as $adir)
    {

        echo "<a href=\"$adir\">";
        echo $adir;
        echo '</a>';
        echo '<br>';
    }
    return $dirarray;
}
?>

<?php

if ( $login === -1)
{
    die();
}

dirlist();

?>