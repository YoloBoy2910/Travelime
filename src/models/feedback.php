<?php

namespace App\Models;

use App\model;

class Feedback extends model {

    public function getFeedbackData() {
        $sql = "SELECT * FROM feedback";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $feedback = $resource->fetch_all(MYSQLI_ASSOC);

        return $feedback;
    }
}