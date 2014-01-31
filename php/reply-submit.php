<?php

include 'functions.php';
require_once 'vendor/autoload.php';

use Mailgun\Mailgun;

if (isset($_POST)) {
    if (isset($_POST["delete"])) {
        deleteMessage($_POST["messageId"]);
        header("location:mails.php?deleted=TRUE");
    } else {
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

        $mailValues = array('from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $message
        );
        if ($bcc) {
            $mailValues["bcc"] = $bcc;
        }
        if ($cc) {
            $mailValues["cc"] = $cc;
        }

        $res = $mg->sendMessage($domain, $mailValues);

        $sent = "success";

//    if($res["success"]){
//        $sent = "danger";
//    }

        header("location:reply.php?id=" . $messageId . "&sent=" . $sent);
    }
}
?>
