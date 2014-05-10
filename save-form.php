<?php

/**
 * AJAX save generated form.
 *
 * @author Adam Studenic
 *
 */

include "functions.php";

$json = array();
$data = array();

if($_POST) {

    $data["id"] = (int) $_POST["formId"];
    unset($_POST["formId"]);

    $json["form"] = $_POST;
    $data["config"] = json_encode($json);
    $data["user_id"] = $_SESSION["user_id"];

    $formId = saveFormConfig($data);

    if(!$formId) {
        $data["config"] = "error";
    }

    $jsonArr = json_decode($data["config"]);

    if($formId == $data["id"]) {
        $jsonArr->new = "false";
    } else {
        $jsonArr->new = "true";
    }
    $jsonArr->formId = $formId;
    $json = json_encode($jsonArr);
}

header('Content-Type: application/json');
echo $json;
?>
