<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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
echo <<<HTML
        <body>
            <form method="post" action="mdr.php5">
                <h2>Username : <input type="text" name="username" value="$username"></h2>
                <h2>Password :&nbsp; <input type="password" name="password" value="$password"> </h2>
                <input type="submit" name="submit" value="admin">
            </form>
        </body>
HTML;
}
?>

<?php
////////* Functions *////////
function dirlist($dirpath = '.')
{
    $dirarray = scandir($dirpath);
    foreach ($dirarray as $adir)
    {
        if ( is_file($adir) === true)//is a file
        {
            echo <<<HTML
            <a href="mdr.php5?$adir=file">$adir</a>|
HTML;
        }
        else
        {
            echo <<<HTML
            <a href="mdr.php5?$adir=dir">$adir</a>|
HTML;
        }
        echo '<br>';
    }
}
?>

<?php

if ( $login === -1)
{
    die();
}
if ( is_string( key($_GET) ) === true )
{
    $path = key($_GET);
    $path = str_replace('_','.',$path);
    if ( is_file($path) === true)//is a file
    {
        header("location: $path");
    }
    else // is a folder
    {
        dirlist($path);
    }
}
else
{
    dirlist();
}
?>