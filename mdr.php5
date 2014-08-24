<!DOCTYPE html>
<html class="htmlid">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mdrfiles/mdr.css">
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

if( isset( $_SESSION['username'] ) === false )
{
    $_SESSION['username'] = "";
}

if( isset($_SESSION['password']) === false )
{
    $_SESSION['password'] = "";
}
?>

<?php
////////* Functions *////////

function dirlist( $getpatharray )
{
    $hardpath = realpath('.');
    $hardpath .= '\\';
    $webpath = $_SESSION['url'];

    foreach( $getpatharray as $key => $value)
    {
        $webpath .= $key;
        $webpath .= '/';
        $hardpath .= $key;
        $hardpath .= '\\';
    }
    $dirarray = scandir($hardpath);
    unset( $dirarray[1] );
    unset( $dirarray[0] );
    foreach ( $dirarray as $adir )
    {
        $ffpath = $hardpath . $adir;
        $webpathtemp = $webpath . $adir;
        if ( is_file( $ffpath ) === true)// is a file
        {
            $pathedit = $ffpath;
            $ffpath = substr_replace($ffpath, 'file:\\\\\\', 0, 0);
            echo <<<HTML
            <a href="mdrfiles/editor.php5?path=$pathedit&bpen=true&weburl=$webpathtemp" target="_blank">$adir &nbsp&nbsp&nbsp&nbsp&nbsp - edit file</a>|
            <a href="$webpathtemp">web url </a>|
            <a href="$ffpath">hard file path.</a>
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
            $createurlParameter .= "=forward";
            echo <<<HTML
            <a href="mdr.php5?$createurlParameter">$adir</a>
HTML;
        }
        echo '<br>';
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
////////* check valid root *////////
if ( $login === -1)
{
    echo<<<HTML
            <body>
                <form method="post" action="mdr.php5?one=true">
                    <h2> Username : <input class="ninput" type="text" name="username" value="$_SESSION[username]"></h2>
                    <h2> Password : <input class="ninput" type="password" name="password" value="$_SESSION[username]"></h2>
                    <h2> enter : <input class="ninput" type="submit" name="submit" value="admin"></h2>
                </form>
            </body>
HTML;
    die();
}
?>

<?php
////////* browse *////////
if ( is_string( key($_GET) ) === true )
{
    $keyg = key($_GET);
    if ( $keyg === "one" && $_GET[$keyg] === "true" )
    {
        header("Location: mdr.php5");
    }
    dirlist($_GET);
}
else
{
    dirlist( array() );
}
?>