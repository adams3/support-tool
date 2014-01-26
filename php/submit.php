<?php

header('Access-Control-Allow-Origin: *');
include 'functions.php';

$domain = $_POST["domain"];
$userId = $_POST["userId"];
$formId = $_POST["formId"];
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

echo json_encode($retArr);
?>