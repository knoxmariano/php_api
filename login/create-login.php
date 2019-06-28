<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// include database and object files
include_once '../config/db.php';
include_once '../object/login.php';

$database = new db();
$db = $database->getConnection();

// initialize object
$login = new login($db);

// get posted data
$data = json_decode(file_get_contents("php://input", true));

$login->uname = $data->uname;
$login->upass = $data->upass;
$login->firstname = $data->firstname;
$login->lastname = $data->lastname;
$login->access = $data->access;
$login->designation = $data->designation;

// create the department
if ($login->create()) {
    echo '{';
    echo '"message": "User was created."';
    echo '}';
}

// if unable to create the department, tell the user
else {
    echo '{';
    echo '"message": "Unable to create user."';
    echo '}';
}
