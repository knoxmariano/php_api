<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/db.php';
include_once '../object/login.php';

// instantiate database and department object
$database = new db();
$db = $database->getConnection();

// initialize object
$login = new login($db);

// query department
$stmt = $login -> read();
$num = $stmt -> rowCount();

// check if more than 0 record found
if ($num > 0) {
    // department array
    $login_arr = array();
    $login_arr["records"] = array();

    // retrieve table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        extract($row);
        $login_item = array(
            "id" => $row['id'],
            "Username" => $row['uname'],
            "Password" => $row['upass']
        );
        array_push($login_arr["records"], $login_item);
    }
    echo json_encode($login_arr);
} else {
    echo json_encode(
            array("message" => "No user found.")
    );
}
?>