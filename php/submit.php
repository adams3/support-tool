<?php

header('Access-Control-Allow-Origin: *');
include 'functions.php';

$domain = $_POST["domain"];
$values = $_POST;
unset($values["domain"]);
$arr = array(
    'date_create%sql' => 'NOW()',
    'message' => json_encode($values),
    'domain' => $domain
);

insertRow($arr);

$retArr = array(
    "class" => "alert-success",
    "alertMessage" => "Great! The form has been successfully sent. You can close this window now."
);

echo json_encode($retArr);
?>