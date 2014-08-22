<!DOCTYPE html>
<html class="htmlid">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mdr.css">
    <title>mdr</title>
</head>
</html>

<?php

$path = $_GET['path'];
$source = fopen($path , "r");
$test = fread($source,filesize($path ));
fclose($source);

echo<<<HTML

<span>
    <form id="format" method="post" action="mdreditor.php5">
        <input type="submit" name="submit" value="Apply">
    </form>
</span>
<br>
<textarea name="textarea" form="format" class="editor" rows="20">$test</textarea>

HTML;


echo<<<HTML

    <iframe src="out.php5"></iframe>

HTML;

?>