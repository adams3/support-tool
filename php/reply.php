<?php
require_once 'header.php';

$rowString = "";
$sent = "";
if(isset($_GET["sent"])) {
    $sent = $_GET["sent"];
}
$configFile = "config/configureForm.json";

$json = json_decode(file_get_contents($configFile), true);
$form = (array) json_decode($json["form"]);

if ($_GET["id"]) {
    $id = $_GET["id"];

    $row = getMessageById($id);
    markMessageAsRead((int) $id);

    $rowString = "\n\n------------------------------------------------------------------------------\n";
    $informMessage = "Customer Message from: ";

    if ($row["replied"]) {
        $informMessage = "Administrator reply from: ";
    }

    $rowString .= $informMessage . date("d.m.Y H:i:s", strtotime($row["date_create"])) . "\n\n";

    $formatedMessage = "";
    $message = (array) json_decode($row["message"]);
    foreach ($message as $key => $input) {
        $formatedMessage .= $key . " : " . $input . "\n";
    }
    $rowString .= $formatedMessage;

//    $domain = "";
    $domain = $row["domain"];
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
}

if ($sent == "success") {
    echo '<div class="alert alert-success">Well done! The message has been successfully sent.</div>';
} else if ($sent == "danger") {
    echo '<div class="alert alert-danger">Oh snap! There was an error while sending this message.</div>';
}
?>
<div class="page-header mt0">
  <h1><?php if($_GET){ echo "Reply to customer <small>Your reply will be saved</small>"; } else { echo "Send an email <small>Your email message will not be saved</small>"; } ?>

  </h1>
</div>
<?php if($_GET){ echo '<a href="/mails.php"><button id="goBack" class="mb20 btn btn-primary " type="button">Back to Query List</button></a>'; } ?>

<div class="well well-new">
    <form id="replyForm" class="form-horizontal" name="reply-form" role="form" action="reply-submit.php" method="post">
        <div id="email">
            <div class="row well well-new-2">
                <div class="col-sm-6 no-pl">
                    <label for="fromInput">From</label>
                    <input name="from" type="email" multiple class="form-control input-new" id="fromInput" placeholder="From" required value="<?php echo $from; ?>">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toInput">To</label>
                    <input name="to" type="email"  multiple class="form-control input-new" id="toInput" placeholder="example@me.com" value="<?php echo $to; ?>" required>
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toCcInput">Send copy to (Cc)</label>
                    <input name="cc" type="email" multiple class="form-control input-new" id="toCcInput" placeholder="example@me.com">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="tobccInput">Send copy to (Bcc)</label>
                    <input name="bcc" type="email" multiple class="form-control input-new" id="toBccInput" placeholder="example@me.com">
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