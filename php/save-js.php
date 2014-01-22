<?php

if ($_POST) {


    $jsFile = $_POST["filename"];
    $hashUserId = $_POST["hashUserId"];
    $hashFormId = $_POST["hashFormId"];
    $path = 'config/' . $hashUserId .'/' . $hashFormId;


    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    $js = $_POST["message"];
    $path .= "/" . $jsFile;
    $fh = fopen($path, 'w+') or die("can't open file");
    fwrite($fh, $js);
    fclose($fh);

    header('Content-Type: application/json');
    echo 1;
}
?>
