<?php

namespace App;

use App\Database;

class Model {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function __destruct() {
        if($this->db) {
            $this->db->close();
        }
    }
}