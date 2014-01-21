<?php

if ($_POST) {

//    var_dump($_POST);die;

    $jsFile = $_POST["filename"];
    $userId = $_POST["userId"];
    $formId = $_POST["formId"];
    $path = 'config/' . $userId .'/' . $formId;


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
