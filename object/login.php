<?php

class login {

    // database connection and table name
    private $conn;
    private $table_name = "tbUsers";
    // object properties

    public $uname;
    public $upass;
    public $firstname;
    public $lastname;
    public $access;
    public $designation;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // read user
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

    // verify user
    function verify() {
        $query = "SELECT d.id, d.uname, d.upass, d.firstname, d.lastname, d.access, d.designation
            FROM
                " . $this->table_name . " d
                WHERE 
                    uname = :uname
                AND 
                    upass = :upass";

        $stmt = $this->conn->prepare($query);

        $this->uname = htmlspecialchars(strip_tags($this->uname));
        $this->upass = htmlspecialchars(strip_tags($this->upass));

        $this->bindParam(':uname', $this->uname);
        $this->bindParam(':upass', $this->upass);

        $stmt->execute();
    }

    // create User
    function create() {
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                uname = :uname,
                upass = :upass,
                fisrtname = :firstname,
                lastname = :lastname,
                access = :access,
                designation = :designation";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->uname = htmlspecialchars(strip_tags($this->uname));
        $this->upass = htmlspecialchars(strip_tags($this->upass));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->access = htmlspecialchars(strip_tags($this->access));
        $this->designation = htmlspecialchars(strip_tags($this->designation));

        // bind values
        $stmt->bindParam(":uname", $this->uname);
        $stmt->bindParam(":upass", $this->upass);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":access", $this->access);
        $stmt->bindParam(":designation", $this->designation);

        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}

