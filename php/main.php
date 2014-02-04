<?php
require_once 'header.php';
?>


<div class="">
    <h1>Welcome to Helpdesk administration</h1>
    <!--<p>
        <a class="btn btn-lg btn-primary" href="#">View navbar docs &raquo;</a>
    </p>-->
</div>
<div class="well well-new">
<a href="/forms.php">You have <strong><?php echo getNumberOfForms($_SESSION["user_id"]) ?></strong> forms</a><br>
<a href="/mails.php">You have <strong><?php echo getNumberOfUnread($_SESSION["user_id"]) ?></strong> new messages.</a>

</div> <!-- /container -->

<?php
require_once 'footer.php';
?>

