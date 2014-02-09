<?php
include "database.php";
include "authenticate.php";
require_once "vendor/autoload.php";
use Mailgun\Mailgun;

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function getNumberOfUnread($userId) {
    $SQL = "SELECT * FROM hd_message WHERE `read` = 0 AND user_id = $userId";

    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
        return count($row);
    } catch (DibiException $e) {
        var_dump($e);
        die;
    }
}

function getNumberOfForms($userId) {
    $SQL = "SELECT * FROM hd_form WHERE user_id = $userId";

    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
        return count($row);
    } catch (DibiException $e) {
        var_dump($e);
        die;
    }
}

function getMessageById($id) {
    $userId = $_SESSION["user_id"];
    $SQL = "SELECT * FROM hd_message WHERE id = $id AND user_id = $userId";
    try {
        $result = dibi::query($SQL);
        $row = $result->fetchAll();
    } catch (DibiException $e) {
        die($e);
    }

    return  isset($row[0]) ? $row[0] : null;
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

function changePassword($email) {
    try {
        $email = mysql_real_escape_string($email);
        $password = rand_passwd();
        $arr["password"] = md5($password);
        $res = dibi::query('UPDATE hd_user SET', $arr, 'WHERE `email` = %s', $email);
        
        if($res) {
            $mg = new Mailgun("key-75wv99jndh25oueyatftijqf09xjk9v5");
            $domain = "sandbox7573.mailgun.org";
            $message = "Dear user,\n\n"
                    . "Your new login:"
                    . "Email: $email\n"
                    . "Password: $password\n\n"
                    . "Have a nice day";

            $mailValues = array('from' => "change-password@support-adams3.rhcloud.com/",
                'to' => $email,
                'subject' => "Changed password",
                'text' => $message
            );
            $mg->sendMessage($domain, $mailValues);
        }
        
        return $res;
        
    } catch (DibiException $e) {
        die($e);
    }
}

function deleteMessage($messageId) {
    try {
        $arr = array("deleted" => 1);
        dibi::query('UPDATE hd_message SET', $arr, 'WHERE id = %i', $messageId);
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
        die("Whooops. Error occured. We are sorry.");
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

function saveFormConfig ($data) {
    try {
        $id = $data["id"];
        unset($data["id"]);
        $result = dibi::query("SELECT id FROM `hd_form` WHERE id = $id");
        $row = $result->fetchAll();

        if($row) {
            dibi::query('UPDATE hd_form SET', $data, 'WHERE id = %i', $id);
        } else {
            $res = dibi::query('INSERT INTO `hd_form`', $data);
            $id = dibi::getInsertId();
        }

        return $id;
    } catch (DibiException $e) {
        return false;
    }

}

function getFormById($id) {
    try {
        $userId = $_SESSION["user_id"];
        $result = dibi::query("SELECT config FROM `hd_form` WHERE id = $id AND user_id = $userId");
        $row = $result->fetchAll();
        
        return isset($row[0]) ? $row[0] : null;
    } catch (DibiException $e) {
        die($e);
    }
}

function fix_keys($array) {
    $numberCheck = false;
    foreach ($array as $k => $val) {
        if (is_array($val)) {
            $array[$k] = fix_keys($val); //recursion
        }
        if (is_numeric($k)) {
            $numberCheck = true;
        }
    }
    if ($numberCheck === true) {
        return array_values($array);
    } else {
        return $array;
    }
}

function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
    return substr( str_shuffle( $chars ), 0, $length );
}
