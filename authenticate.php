<?php

/**
 * System authentication
 *
 * @author Adam Studenic
 *
 */

session_start();

//Registration
if ( isset($_POST["submit"]) && $_POST["submit"] == "register") {
    $data = $_POST;
    unset($data["submit"]);
    if(register($data)) {
        header("location:index.php?success=registered");
    } else {
        header("location:index.php?success=exists&email=".$data["email"]);
    }
    exit();
}

//Forgotten password
if ( isset($_POST["submit"]) && $_POST["submit"] == "forgotPassword") {
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    if(changePassword($email)) {
        header("location:index.php?success=changedPassword&email=".$email);
    } else {
        header("location:index.php?success=not-exists&email=".$email);
    }
    exit();
}

if ( isset($_POST["submit"]) && isset($_POST["email"]) && $_POST["submit"] == "login" && $_POST["email"] && $_POST["password"]) {
    $user = login($_POST["email"], $_POST["password"]);
    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
    } else {
        header("location:index.php?success=false");
        exit();
    }
}

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:index.php");
    exit();
}

