<?php

require dirname(__FILE__) . '/../libs/dibi/dibi/dibi.php';

$options = array(
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'support_db',
);

// v případě chyby vyhodí DibiException
try {
    dibi::connect($options);
} catch (DibiException $e) {
    echo"ahoj";
};

?>
