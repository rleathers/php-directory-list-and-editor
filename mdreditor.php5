<?php
var_dump($_GET);
$p = $_GET['path'];
$source = fopen($p, "r");
echo fread($source,filesize($p));
fclose($source);
?>