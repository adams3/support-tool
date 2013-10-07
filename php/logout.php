<?php
session_start();
if(isset($_SESSION["login"])){
    unset($_SESSION["login"]);
    unset($_SESSION["password"]);
}

header("location:index.php?success=true");

?>
