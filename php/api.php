<?php

//Reception/Proccessing room

//to display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//proccess the request.
//handed over to API. API IS NOW handing it over for processing.


//GET SERVICE-retrieve

//1. what is the request type.
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['service'])) {

    $service = isset($_GET['service']) ?  $_GET['service'] : null;
    $filter =  isset($_GET['filter']) ?  $_GET['filter'] : null;
    $id =  isset($_GET['id']) ?  $_GET['id'] : null;
    $columns = isset($_GET['columns']) ?  $_GET['columns'] : null;

    switch ($service) {

        //Users
        case 'get_users':
        case 'get_user':
        case 'authenticate_user':
            require('service/user.php');
            break;
       
    }
}

// POST SERVICE -create

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['service'])) {

    $service = isset($_POST['service']) ?  $_POST['service'] : null;
    $data = isset($_POST['data']) ? $_POST['data'] : null;

    switch ($service) {
        //Users
        case 'create_user':
            require('service/user.php');
            break;
        case 'deactivate_user':
            require('service/deactivate.php');
            break;
    }
}


//PUT SERVICE -update

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $rawData = file_get_contents('php://input');

    // Decode the JSON data into an associative array
    $decodedData = json_decode($rawData, true);

    $service = $decodedData['service'];
    $id = $decodedData['id'] ?? null;
    $data = $decodedData['data'] ?? null;

    switch ($service) {
        //Users
        case 'update_user':
            require('services/users.php');
            break;
    }
}


//DELETE SERVICE - delete

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $rawData = file_get_contents('php://input');

    // Decode the JSON data into an associative array
    $decodedData = json_decode($rawData, true);

    $service = $decodedData['service'];
    $id = $decodedData['id'] ?? null;
    
    switch ($service) {
        //Users
        case 'delete_user':
            require('services/users.php');
            break;
    }
}

?>
