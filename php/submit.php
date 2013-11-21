<?php
header('Access-Control-Allow-Origin: *');
include 'database.php';

var_dump(json_encode($_GET));

$args = array(
    'date_create%sql' => 'NOW()',
    'message' => json_encode($_GET)
);

dibi::query('INSERT INTO `hd_message`', $args);

//$result = dibi::query('SELECT * FROM `hd_message`');
//var_dump($result->fetchAll());




//require_once dirname(__FILE__) . '/vendor/autoload.php';
//
//use Mailgun\Mailgun;
//
//$to = "a.studenic@gmail..com";
//$subject = "support";
//$from = $_GET["mail"];
//$message = $_GET["message"] . "\n\n" . print_r($_GET, true);
//
//
//
///*
//  print_r($_GET);
//  $headers = 'From: ' . $from;
//  mail($to, $subject, $message, $headers);
// */
//
//$mg = new Mailgun("key-42jfgix5x0d01p51hi2jyqinl7ao6tz7");
//$domain = "sportpassapp.com";
//
//$mg->sendMessage($domain, array('from' => $from,
//    'to' => $to,
//    'subject' => $subject,
//    'text' => $message));
//?>
Message has been sent