<?php

namespace App\Models;

use App\model;

Class TravelAdvice extends Model {
    
    public function getTravelAdvice() {
        $sql = "SELECT * FROM traveladvice";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $items = $resource->fetch_all(MYSQLI_ASSOC);
        return $items;
    }

    public function getAdviceByCountry($country) {
        $sql = "SELECT * FROM traveladvice WHERE country = $country";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $items = $resource->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
}