<?php
include "functions.php";
session_start();

$json = array();

if($_POST) {
    $json["form"] = $_POST;

    $data = array();
    $data["config"] = json_encode($json);
    $data["user_id"] = $_SESSION["user_id"];

    if(!saveFormConfig($data)) {
        $data["config"] = "error";
    }
}

header('Content-Type: application/json');
echo $data["config"];
?>
