<?php

namespace App;

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "travelime";
    private $conn;

    public function __construct()
    {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Error couldn't connect to database: " . $this->conn->connect_error);
        }
    }

    public function conn()
    {
        return $this->conn;
    }

    public function query($sql)
    {
        $result = $this->conn->query($sql);
        return $result;
    }

    public function close()
    {
        $this->conn->close();
    }
}
