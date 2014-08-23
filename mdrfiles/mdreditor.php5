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
if ( $_SESSION['login'] === -1)
{
    //// redirct to mdr.php5
    die();
}
?>

<?php
if ( isset ( $_SESSION['firstlogin'] ) === false )
{
    $_SESSION['firstlogin'] = true;
    $textp = file_get_contents( $_GET['path'] );
    file_put_contents("out.php5" , $textp);
}
?>

<?php

if( isset ( $_POST['textarea'] ) )
{
    file_put_contents("out.php5" , $_POST['textarea']);
}

?>

<?php

$text = file_get_contents("out.php5");

echo<<<HTML

<span>
    <form id="format" method="post" action="mdreditor.php5?path=$_GET[path]">
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