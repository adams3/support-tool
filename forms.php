<?php

/**
 * Displaying all forms
 *
 * @author Adam Studenic
 *
 */

require_once 'header.php';

if (isset($_GET["deleted"]) && $_GET["deleted"] == "success") {
    echo '<div class="alert alert-success">Form has been successfully deleted.</div>';
}
?>

<div id="forms">
    <table id="jqGridForms"></table>
    <div id="pager"></div>
</div>


<?php
require_once 'footer.php';
?>
