<?php
include 'database.php';
include 'functions.php';
require_once 'header.php';
//require_once 'vendor/autoload.php';
//
//use Mailgun\Mailgun;

$rowString = "";
$configFile = "config/configureForm.json";

$json = json_decode(file_get_contents($configFile), true);
$form = (array) json_decode($json["form"]);


if ($_GET["id"]) {
    $id = $_GET["id"];
    $SQL = "SELECT * FROM hd_message WHERE id = $id";

    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    };

    $row = $row[0];
    $rowString = "\n\n------------------------------------------------------------------------------\n";
    $informMessage = "Your message from: ";
    if($row["replied"]) {
        $informMessage = "Administrator reply from: ";
    }
    $rowString .= $informMessage . date("d.m.Y H:i:s", strtotime($row["date_create"])) . "\n\n";

    if (isJson($row["message"])) {
        $message = (array) json_decode($row["message"]);
        $formatedMessage = "";
        foreach ($message as $key => $input) {
            $formatedMessage .= $key . " : " . $input . "\n";
        }
    } else {
        $formatedMessage = $row["message"];
    }

    $rowString .= $formatedMessage;

    $domain = "";
//    $domain = $row["domain"];
    $from = $form["send-to"];
    $to = "";

    $matches = array();
    $pattern = '/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i';
    preg_match_all($pattern, $formatedMessage, $matches);
    $i = 0;
    foreach ($matches[0] as $match) {
        if ($i) {
            $to .= ", ";
        }
        $to .= $match;
        $i++;
    }

    $subject = "Reply to query no. " . $row["id"] . " from " . $domain;

    //pri odoslani formulara z frontu, odoslat aj domenu z ktorej je form odoslany
    //do db dorobit domain
}

//if ($_POST) {
//
//    $to = $_POST["to"];
//    $subject = $_POST["subject"];
//    $from = $_POST["from"];
//    $cc = $_POST["cc"];
//    $bcc = $_POST["bcc"];
//    $message = $_POST["message"];
//    $messageId = $_POST["messageId"];
//
//    $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
//    $domain = "sandbox7573.mailgun.org";
//
//    if (!empty($messageId)) {
//        $arr = array();
//        $arr["replied"] = 1;
//        $arr["message"] = json_encode(array("reply" => $message));
//        $arr['date_create%sql'] = 'NOW()';
//        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $messageId);
//    }
//
////    $res = $mg->sendMessage($domain, array('from' => $from,
////        'to' => $to,
////        'cc' => $cc,
////        'bcc' => $bcc,
////        'subject' => $subject,
////        'text' => $message));
//
//    header("location:reply.php?id=". $messageId);
//}
?>

<div class="well well-new">
    <form id="replyForm" class="form-horizontal" name="reply-form" role="form" action="reply-submit.php" method="post">
        <div id="email">
            <div class="row well well-new-2">
                <div class="col-sm-6 no-pl">
                    <label for="fromInput">From</label>
                    <input name="from" type="email" class="form-control input-new" id="fromInput" placeholder="From" required value="<?php echo $from; ?>">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toInput">To</label>
                    <input name="to" type="email" class="form-control input-new" id="toInput" placeholder="example@me.com" value="<?php echo $to; ?>" required>
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toCcInput">Send copy to (Cc)</label>
                    <input name="cc" type="email" class="form-control input-new" id="toCcInput" placeholder="example@me.com">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="tobccInput">Send copy to (Bcc)</label>
                    <input name="bcc" type="email" class="form-control input-new" id="toBccInput" placeholder="example@me.com">
                </div>
            </div>
            <div class="row well well-new-2">
                <div class="col-md-12 no-pl">
                    <label for="subject">Subject</label>
                    <input name="subject" type="text" class="form-control input-new" id="subject" placeholder="Subject" required value="<?php echo $subject ?>">
                </div>
                <div class="col-md-12 no-pl">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="10"><?php echo $rowString; ?></textarea>
                </div>
            </div>
            <input name="messageId" type="hidden" value="<?php echo $id; ?>" />

        </div>
        <br>
        <div class="separator mt15"/></div>
<div class=" center add mt15">
    <div class=" col-md-12 no-pl">
        <input id="send" type="submit" class="btn btn-success" value="Send message">
    </div>
</div>
</form>
</div> <!-- /container -->


<?php
require_once 'footer.php';
?>