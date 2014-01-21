<?php
include "functions.php";
session_start();

$json = array();
$data = array();

if($_POST) {

    $data["id"] = (int) $_POST["formId"];
    unset($_POST["formId"]);

    $json["form"] = $_POST;
    $data["config"] = json_encode($json);
    $data["user_id"] = $_SESSION["user_id"];

    if(!saveFormConfig($data)) {
        $data["config"] = "error";
    }
}

header('Content-Type: application/json');
echo $data["config"];
?>
