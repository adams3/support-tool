<?php

include 'database.php';

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function getNumberOfUnread() {
    $SQL = "SELECT * FROM hd_message WHERE `read` = 0";

    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
        return count($row);
    } catch (DibiException $e) {
        var_dump($e);
    }
}

function getMessageById($id) {
    $SQL = "SELECT * FROM hd_message WHERE id = $id";
    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    }

    return $row[0];
}

function markMessageAsRead($id) {
    $arr = array("read" => 1);

    try {
        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $id);
    } catch (DibiException $e) {
        die($e);
    }
}

function updateRow($arr, $messageId) {
    try {
        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $messageId);
    } catch (DibiException $e) {
        die($e);
    }
}

function insertRow($arr) {
    try {
        dibi::query('INSERT INTO `hd_message`', $arr);
    } catch (DibiException $e) {
        die($e);
    }
}

function login($email, $password) {
    try {
        $email = mysql_real_escape_string($email);
        $password = md5(mysql_real_escape_string($password));

        $result = dibi::query("SELECT id, email, name, surname FROM `hd_user` WHERE email = '$email' AND password = '$password'");
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    }
    return $row[0];
}

function register($data) {
    try {
        $data["email"] = mysql_real_escape_string($data["email"]);
        $data["password"] = md5(mysql_real_escape_string($data["password"]));
        $data["name"] = mysql_real_escape_string($data["name"]);
        $data["surname"] = mysql_real_escape_string($data["surname"]);
        dibi::query('INSERT INTO `hd_user`', $data);

        return true;
    } catch (DibiException $e) {
        return false;
    }
}
