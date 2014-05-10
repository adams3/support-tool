<?php

/**
 * Returns form detail in JSON.
 *
 * @author Adam Studenic
 *
 */

include "functions.php";

$json = "";
$data = array();

if($_GET["formId"]) {

    $formId = (int) $_GET["formId"];
    $data = getFormById($formId);
    if($data) {
        $jsonArr = json_decode($data["config"]);
        $jsonArr->userId = $_SESSION["user_id"];
        $jsonArr->formId = $formId;
        $jsonArr->hashUserId = md5($_SESSION["user_id"]);
        $jsonArr->hashFormId = md5($formId);

        $json =  json_encode ($jsonArr);
    }
}

header('Content-Type: application/json');
echo $json;

?>
