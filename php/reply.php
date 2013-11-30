<?php
include 'database.php';
require_once 'header.php';

$id = $_GET["id"];
$SQL = "SELECT * FROM hd_message WHERE id = $id";


try {
    $result = dibi::query($SQL);
    $row = $result->fetchAll();
} catch (DibiException $e) {
    var_dump($e);
};

$row = $row[0];

//var_dump($row["id"]);
// TODO zmenit formular a vyplnit mailto addCC Bcc atd a spravu dat a napojit na mailgun
?>


<div class="well well-new">

    <form id="replyForm" class="form-horizontal" name="reply-form" role="form" action="reply.php" method="post">
        <div id="email">
            <div class="row well well-new-2">
                <div class="col-sm-6 no-pl">
                    <label for="fromInput">From</label>
                    <input name="from" type="text" class="form-control input-new" id="fromInput" placeholder="From ">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toInput">To</label>
                    <input name="to" type="text" class="form-control input-new" id="toInput" placeholder="example@me.com">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="toCcInput">Send copy to (Cc)</label>
                    <input name="toCc" type="text" class="form-control input-new" id="toCcInput" placeholder="example@me.com">
                </div>
                <div class="col-sm-6 no-pl">
                    <label for="tobccInput">Send copy to (Bcc)</label>
                    <input name="toBcc" type="text" class="form-control input-new" id="toBccInput" placeholder="example@me.com">
                </div>
            </div>
            <div class="row well well-new-2">
                <div class="col-md-12 no-pl">
                    <label for="subject">Subject</label>
                    <input name="subject" type="text" class="form-control input-new" id="subject" placeholder="Subject">
                </div>
                <div class="col-md-12 no-pl">
                    <label for="subject">Message</label>
                    <textarea name="message" class="form-control" rows="10"></textarea>
                </div>
            </div>


        </div>
        <br>
        <div class="separator mt15"/></div>
<div class=" center add mt15">
    <div class=" col-md-12 no-pl">
        <button id="sendMessage" type="submit" class="btn btn-success">Send message</button>
    </div>
</div>

</form>
</div> <!-- /container -->


<?php
require_once 'footer.php';
?>