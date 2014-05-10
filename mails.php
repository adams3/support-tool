<?php


/**
 * Displaying all messages
 *
 * @author Adam Studenic
 *
 */

require_once 'header.php';

if (isset($_GET["deleted"]) && $_GET["deleted"] == "success") {
    echo '<div class="alert alert-success">Customer query has been successfully deleted.</div>';
}

?>

<div id="mails">
    <table id="jqGridMails"></table>
    <div id="pager"></div>
</div>


<?php
require_once 'footer.php';
?>
