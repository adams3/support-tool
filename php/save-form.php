<?php
include "functions.php";
session_start();

$json = array();
$data = array();

if($_POST) {
//    $json["form"] = $_POST["form"];

    var_dump($_POST);die;
    $data["config"] = json_encode($json);
    $data["user_id"] = $_SESSION["user_id"];
    $data["id"] = $_POST["formId"];

    if(!saveFormConfig($data)) {
        $data["config"] = "error";
    }
}

header('Content-Type: application/json');
echo $data["config"];
?>
