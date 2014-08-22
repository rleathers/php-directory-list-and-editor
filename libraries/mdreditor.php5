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

<form method="post" action="mdreditor.php5">
    <textarea class="editor" rows='20'>
    $test;
    </textarea>;
</form>

HTML;


echo<<<HTML

    <iframe src="out.php5"></iframe>

HTML;

?>