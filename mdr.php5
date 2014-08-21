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
if( isset( $_SESSION['currentpath'] ) === false )
{
    $_SESSION['currentpath'] = array();
}
?>

<?php
////////* Functions *////////
function dirlist($currentpatharray)
{
    $hardpath = realpath('.');
    $hardpath .= '/';
    $webpath = $_SESSION['url'];
    foreach( $currentpatharray as $key => $value)
    {
        $webpath .= $key;
        $webpath .= '/';
        $hardpath .= $key;
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
            $ffpath = substr_replace($ffpath, 'file:\\\\\\', 0, 0);
            echo <<<HTML
            <a href="$ffpath">$adir ( localhost {for test} )</a>|
            <a href="$webpathtemp">$adir ( form web )</a>|
            <a href="#?edit=true">$adir ( edit )</a>|
HTML;
        }
        else// is a folder
        {
            $createurlParameter = "";
            foreach ( $_GET as $key => $dir )
            {
                $createurlParameter .= $key;
                $createurlParameter .= '=';
                $createurlParameter .= $dir;
                $createurlParameter .= "&";
            }
            $createurlParameter .= $adir;
            $createurlParameter .= "=dir";
            echo <<<HTML
            <a href="mdr.php5?$createurlParameter">$adir</a>|
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
////////* browse *////////
if ( is_string( key($_GET) ) === true )
{
    echo " get" ;var_dump( $_GET );

    $path = key($_GET);
    if( 1 )
    {
        dirlist($_GET);
    }
    else
    {
        $source = fopen("test.html", "r") or die("cant file!");
        echo fread($source,filesize("test.html"));
        fclose($source);
    }
}
else
{
    dirlist( array() );
}
?>