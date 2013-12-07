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
    };
}

function getMessageById($id) {
    $SQL = "SELECT * FROM hd_message WHERE id = $id";
    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    };

    return $row[0];
}

function markMessageAsRead($id) {
    $arr = array("read" => 1);

    try {
        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $id);
    } catch (DibiException $e) {
        die($e);
    };
}

function updateRow($arr, $messageId) {
    try {
        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $messageId);
    } catch (DibiException $e) {
        die($e);
    };
}

function insertRow($arr) {
    try {
        dibi::query('INSERT INTO `hd_message`', $arr);
    } catch (DibiException $e) {
        die($e);
    };
}
