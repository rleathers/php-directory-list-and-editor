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
if( isset($_SESSION['url']) === false )
{
    $_SESSION['url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $_SESSION['url'] = str_replace('mdr.php5','',$_SESSION['url']);
}
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
////////* Functions *////////
function dirlist($dirpath)
{
    $hardpath = realpath('.');
    $hardpath .= '/';
    $webpath = $_SESSION['url'];
    foreach( $dirpath as $value)
    {
        $webpath .= $value;
        $webpath .= '/';
        $hardpath .= $value;
        $hardpath .= '/';
    }
    $dirarray = scandir($hardpath);
    $hardpath = str_replace("/",'\\',$hardpath);
    foreach ($dirarray as $adir)
    {
        $ffpath = $hardpath . $adir;
        $webpathtemp = $webpath . $adir;
        if ( is_file($ffpath) === true)// is a file
        {
            //$ffpath = str_replace("\\",'\\\\',$ffpath);
            $ffpath = substr_replace($ffpath, 'file:\\\\\\', 0, 0);
            echo <<<HTML
            <a href="$ffpath">$adir ( form hard )</a>|
            <a href="$webpathtemp">$adir ( form web )</a>|
HTML;
        }
        else// is a folder
        {
            echo <<<HTML
            <a href="mdr.php5?$adir=dir">$adir</a>|
HTML;
        }
        echo '<br>';
    }
}
function detectrefresh()
{
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    if($pageWasRefreshed )
    {
        return true;
    }
    else
    {
        return false;
    }

}
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

////////* check valid root *////////
if ( $login === -1)
{
    die();
}
if( isset( $_SESSION['currentpath'] ) === false )
{
    $_SESSION['currentpath'] = array();
}
////////* browse *////////
if ( is_string( key($_GET) ) === true )
{
    var_dump( $_GET );
    var_dump( $_SESSION['currentpath'] );
    $path = key($_GET);
    if( $_GET["$path"] === "dir" )
    {
        if( detectrefresh() == false )
        {
            array_push( $_SESSION['currentpath'] , $path );
        }
        dirlist($_SESSION['currentpath']);
    }
    else
    {
        $hardpath = realpath('.');
        $hardpath .= '/';
        foreach( $_SESSION['currentpath'] as $value)
        {
            $hardpath .= $value;
            $hardpath .= '/';
        }
        $path = str_replace('_','.',$path);
        $hardpath .= $path;
        var_dump($hardpath);

        header("location: $hardpath");
    }
}
else
{
    dirlist( array() );
}
?>