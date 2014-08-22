<?php
$source = fopen("test.html", "r") or die("cant file!");
echo fread($source,filesize("test.html"));
fclose($source);
?> 