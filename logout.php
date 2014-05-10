<?php

/**
 * Logout from system
 *
 * @author Adam Studenic
 *
 */


session_start();
$_SESSION = array();
session_destroy();

header("location:index.php?success=true");
exit();

?>
