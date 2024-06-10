<?php

namespace App\Models;

use App\model;

class TravelAdvice extends Model
{

    public function getTravelAdvice()
    {
        $sql = "SELECT countryName, countryImage FROM traveladvice";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $items = $resource->fetch_all(MYSQLI_ASSOC);
        return $items;
    }

    public function getAdviceByCountry($country)
    {
        //Check for spaces. Urls turn spaces in %20 cause urls can't have spaces.
        if (str_contains($country, "%20")) {
            $country = str_replace("%20", " ", $country);
        }

        $sql = "SELECT * FROM traveladvice WHERE countryName = \"$country\"";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $items = $resource->fetch_assoc();
        if ($items == null) $items = "404";
        return $items;
    }

    public function getRandomCountry()
    {
        $sql = "SELECT * FROM traveladvice ORDER BY RAND() LIMIT 1";
        $resource = $this->db->conn()->query($sql) or die($this->db->conn()->error);
        $items = $resource->fetch_assoc();
        return $items;
    }
}
