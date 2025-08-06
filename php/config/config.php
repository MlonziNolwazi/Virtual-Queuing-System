<?php

$HOST = 'localhost';
$USER ='root';
$PASS = '';
$DB = 'virtual_queue_system';
$connect = mysqli_connect($HOST,$USER, $PASS, $DB);

if(!$connect){
    header('Content-Type: application/json');
    die(json_encode("Unable to connect to database ".$DB. " - ".mysqli_connect_error()));
    //header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>