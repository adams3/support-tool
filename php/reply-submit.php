<?php

include 'functions.php';
require_once 'vendor/autoload.php';

use Mailgun\Mailgun;

if ($_POST) {
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $from = $_POST["from"];
    $cc = $_POST["cc"];
    $bcc = $_POST["bcc"];
    $message = $_POST["message"];
    $messageId = $_POST["messageId"];

    $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
    $domain = "sandbox7573.mailgun.org";


    if (!empty($messageId)) {
        $arr = array();
        $arr["replied"] = 1;
        $arr["message"] = json_encode(array("reply" => $message));
        $arr['date_create%sql'] = 'NOW()';

        updateRow($arr, $messageId);
    }

//    $res = $mg->sendMessage($domain, array('from' => $from,
//        'to' => $to,
//        'cc' => $cc,
//        'bcc' => $bcc,
//        'subject' => $subject,
//        'text' => $message
//            ));
//
    $sent = "success";
//    if($res["success"]){
//        $sent = "danger";
//    }

    header("location:reply.php?id=" . $messageId . "&sent=" . $sent);
}
?>
