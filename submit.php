<?php

header('Access-Control-Allow-Origin: *');
include "database.php";

if (isset($_POST)) {

    $domain = (isset($_POST["domain"]) ? $_POST["domain"] : "");
    $userId = (isset($_POST["userId"]) ? $_POST["userId"] : "");
    $formId = (isset($_POST["formId"]) ? $_POST["formId"] : "");
    $values = $_POST;

    unset($values["domain"]);
    unset($values["userId"]);
    unset($values["formId"]);
    $arr = array(
        'date_create%sql' => 'NOW()',
        'message' => json_encode($values),
        'domain' => $domain,
        'user_id' => $userId,
        'form_id' => $formId
    );

    insertRow($arr);

    $retArr = array(
        "class" => "alert-success",
        "alertMessage" => "Great! The form has been successfully sent. You can close this window now."
    );
} else {

    $retArr = array(
        "class" => "alert-danger",
        "alertMessage" => "Oops. Something went wrong."
    );
}

echo json_encode($retArr);

function insertRow($arr) {
    try {
        dibi::query('INSERT INTO `hd_message`', $arr);
    } catch (DibiException $e) {
        die($e);
    }
}
?>