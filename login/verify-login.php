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

$login = new login($db);

echo phpversion();
//Get raw posted data
$data = json_decode(file_get_contents("php//input", TRUE));

$login->uname = $data->uname;
$login->upame = $data->upass;

$stmt = $login -> verify();
$num = $stmt -> rowCount();

if ($num > 0) {

    $login_arr = array();
    $login_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $login_item = array(
            "id" => $row['id'],
            "Username" => $row['uname'],
            "Password" => $row['upass'],
            "Firstname" => $row['firstname'],
            "Lastname" => $row['lastname'],
            "Access" => $row['access'],
            "Designation" => $row['designation']
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