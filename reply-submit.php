<?php


/**
 * Processing POST reply
 *
 * @author Adam Studenic
 *
 */


include 'functions.php';
require_once 'libs/autoload.php';
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

        if (!empty($messageId)) {
            $arr = array();
            $arr["replied"] = 1;
            $arr["message"] = json_encode(array("reply" => $message));
            $arr['date_create%sql'] = 'NOW()';

            updateRow($arr, $messageId);
        }

        $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
        $domain = "sandbox7573.mailgun.org";

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
        if($messageId) {
            header("location:reply.php?id=" . $messageId . "&sent=" . $sent);
            exit();
        } else {
            header("location:reply.php?sent=" . $sent);
        }


    }
}
?>
