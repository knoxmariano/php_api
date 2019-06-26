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

    // read login
    function read() {
        // query to select all
        $query = "SELECT d.id, d.uname, d.upass, d.firstname, d.lastname, d.access, d.designation
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

    // verify
    function verify() {
        $query = "SELECT d.id, d.uname, d.upass, d.firstname, d.lastname, d.access, d.designation
            FROM
                " . $this->table_name . " d
                WHERE uname = :uname AND upass = :upass";

        $stmt = $this->conn->prepare($query);

        $this->uname = htmlspecialchars(strip_tags($this->uname));
        $this->upass = htmlspecialchars(strip_tags($this->upass));

        $this->bindParam(':uname', $this->uname);
        $this->bindParam(':upass', $this->upass);

        if ($stmt->execute()){
            return $stmt;
        } else {
            return false;
        }
    }

}

