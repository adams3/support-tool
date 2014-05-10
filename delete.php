<?php

/**
 * Process mail/form delete request
 *
 * @author Adam Studenic
 *
 */

include "functions.php";


if($_GET["id"] && $_GET["action"]) {

    $id = (int) $_GET["id"];
    $action = $_GET["action"];

    if($action == "form"){
        deleteForm($id);
    } else {
        deleteMessage($id);
    }
}

?>
