<!DOCTYPE html>
<html class="htmlid">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mdr.css">
    <title>mdr</title>
</head>
</html>

<?php
session_start();
if ( isset ( $_SESSION['login'] ) === false )
{
    $ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ur = str_replace('mdrfiles/editor.php5','mdr.php5',$ur);
    header("Location: $ur");
    die();
}
if ( $_SESSION['login'] === -1 )
{
    $ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ur = str_replace('mdrfiles/editor.php5','mdr.php5',$ur);
    header("Location: $ur");
    die();
}
?>

<?php
if ( isset ( $_GET['bpen'] ) === true && $_GET['bpen'] === "true" )
{
    $textp = file_get_contents( $_GET['path'] );
    file_put_contents("out.php5" , $textp);
    unset ( $_GET['bpen'] );
    $ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ur = str_replace('&bpen=true','',$ur);
    header("Location: $ur");
    die();
}
?>

<?php

if ( isset ( $_POST['save'] ) === true )
{
    file_put_contents( $_GET['path'] , $_POST['textarea'] );
}

if( isset ( $_POST['textarea'] ) )
{
    file_put_contents("out.php5" , $_POST['textarea']);
}

?>

<?php

$text = file_get_contents("out.php5");

echo <<<HTML

<span>
    <form id="format" method="post" action="editor.php5?path=$_GET[path]">
        <input type="submit" name="submit" value="Apply">
        <input type="submit" name="save" value="save">
    </form>
</span>
<br>
<textarea name="textarea" form="format" class="editor" rows="20">$text</textarea>

HTML;

echo<<<HTML

    <iframe src="out.php5"></iframe>

HTML;

?>