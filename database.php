<?php
require 'libs/dibi/dibi/dibi.php';

$options = array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'support_db',
);

// define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
// define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
// define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
// define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
// define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
//
// $options = array(
//     'driver' => 'mysql',
//     'host' => DB_HOST,
//     'username' => DB_USER,
//     'password' => DB_PASS,
//     'database' => DB_NAME
// );

// v případě chyby vyhodí DibiException
try {
    dibi::connect($options);
} catch (DibiException $e) {
    die("error db connection");
};

?>
