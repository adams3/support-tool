<?php
include "functions.php";
session_start();

$json = array();
$data = array();

if($_GET["formId"]) {

    $formId = (int) $_GET["formId"];
    $data = getFormById($formId);

    $jsonArr = json_decode($data["config"]);
    $jsonArr->userId = md5($_SESSION["user_id"]);
    $jsonArr->formId = md5($formId);

    $json =  json_encode ($jsonArr);

}

header('Content-Type: application/json');
echo $json;

?>
