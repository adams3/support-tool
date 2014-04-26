<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
include "database.php";

require_once 'libs/autoload.php';

use Mailgun\Mailgun;

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

    $insertedId = insertRow($arr);

    $row = getMessageById($insertedId);
    $user = getUser($row["user_id"]);
    $formattedMessage = formatMessage($row);
    $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
    $domain = "sandbox7573.mailgun.org";

    $mailValues = array('from' => "no-reply@support-adams3.rhcloud.com",
        'to' => $user["email"],
        'subject' => "Message number: " . $insertedId,
        'text' => $formattedMessage
    );
    $res = $mg->sendMessage($domain, $mailValues);

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

function formatMessage($row) {
    $formatedMessage = "";
    $message = (array) json_decode($row["message"]);
    foreach ($message as $key => $input) {
        if(is_array($input)) {
            $input = implode(", ", $input);
        }

        $formatedMessage .= $key . " : " . $input . "\n";
    }
    return $formatedMessage;
}

function insertRow($arr) {
    try {
        $res = dibi::query('INSERT INTO `hd_message`', $arr);
        return dibi::getInsertId();
    } catch (DibiException $e) {
        die($e);
    }
}

function getMessageById($id) {
    $SQL = "SELECT * FROM hd_message WHERE id = $id";
    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    }

    return isset($row[0]) ? $row[0] : null;
}

function getUser($userId) {
    try {
        $result = dibi::query("SELECT * FROM `hd_user` WHERE id = $userId");
        $row = $result->fetchAll();

        return isset($row[0]) ? $row[0] : null;
    } catch (DibiException $e) {
        die($e);
    }
}

?>