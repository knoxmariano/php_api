<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/db.php';
include_once '../object/department.php';

$database = new Db();
$db = $database->getConnection();

// initialize object
$department = new Department($db);

// get posted data
$data = json_decode(file_get_contents("php://input", true));

// set department property value
$department->name = $data->name;

// create the department
if ($department->create()) {
    echo '{';
    echo '"message": "Department was created."';
    echo '}';
}

// if unable to create the department, tell the user
else {
    echo '{';
    echo '"message": "Unable to create department."';
    echo '}';
}

// create department
    function create() {
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                dept_name=:name";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind values
        $stmt->bindParam(":name", $this->name);

        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }