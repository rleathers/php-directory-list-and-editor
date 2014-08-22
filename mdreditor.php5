<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mdr.css">
    <title>mdr</title>
</head>
</html>


<?php
$path = $_GET['path'];
$source = fopen($path , "r");
echo "<textarea class=\"editor\">";
echo fread($source,filesize($path ));
echo "</textarea>";
fclose($source);
?>