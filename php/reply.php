<?php
include 'database.php';
require_once 'header.php';
require_once 'vendor/autoload.php';

use Mailgun\Mailgun;

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
}

if ($_POST) {

    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $from = $_POST["from"];
    $cc = $_POST["cc"];
    $bcc = $_POST["bcc"];
    $message = $_POST["message"];

//var_dump($_POST);die;
//    $to = "a.studenic@gmail.com";
//    $subject = "sadasdasd";
//    $from = "a.studenic@gmail.com";
//    $message = "jksanksad asdkjkjasd sadkjkjsad sadjkns asdmnaskdn";


    $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
    $domain = "sandbox7573.mailgun.org";

    $res = $mg->sendMessage($domain, array('from' => $from,
        'to' => $to,
        'cc' => $cc,
        'bcc' => $bcc,
        'subject' => $subject,
        'text' => $message));

    var_dump($res);
//    die;
}
//var_dump($row["id"]);
// TODO zmenit formular a vyplnit mailto addCC Bcc atd a spravu dat a napojit na mailgun
//http://stackoverflow.com/questions/14440444/extract-all-email-addresses-from-bulk-text-using-jquery
?>

<div class="well well-new">
    <form id="replyForm" class="form-horizontal" name="reply-form" role="form" action="reply.php" method="post">
        <div id="email">
            <div class="row well well-new-2">
                <div class="col-sm-6 no-pl">
                    <label for="fromInput">From</label>
                    <input name="from" type="email" class="form-control input-new" id="fromInput" placeholder="From" required>
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toInput">To</label>
                    <input name="to" type="email" class="form-control input-new" id="toInput" placeholder="example@me.com" required>
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
                    <input name="subject" type="text" class="form-control input-new" id="subject" placeholder="Subject" required>
                </div>
                <div class="col-md-12 no-pl">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="10"></textarea>
                </div>
            </div>

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