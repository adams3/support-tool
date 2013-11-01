<?php
$jsFile = $_POST["filename"];

$js = $_POST["message"];
$fh = fopen($jsFile,'w+') or die("can't open file");
fwrite($fh, $js);
fclose($fh);

header('Content-Type: application/json');
echo 1;
?>
