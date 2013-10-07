<?php
$configFile = "config/configureForm.json";

$json = json_decode(file_get_contents($configFile), true);
$json["form"] = json_encode($_POST);

$fh = fopen($configFile,'w+') or die("can't open file");
fwrite($fh, json_encode($json));
fclose($fh);

header('Content-Type: application/json');
echo file_get_contents(($configFile), true);
?>
