<?php

class login {

    // database connection and table name
    private $conn;
    private $table_name = "tbUsers";
    // object properties
    public $id;
    public $uname;
    public $upass;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // read departments
    function read() {
        // query to select all
        $query = "SELECT d.id, d.uname, d.upass
            FROM
                " . $this->table_name . " d
            ORDER BY
                d.id";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

}

