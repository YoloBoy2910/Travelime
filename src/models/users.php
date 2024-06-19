<?php

namespace App\Models;

use App\Model;

class User extends Model
{

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $statement = $this->db->conn()->prepare($sql);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }

    public function checkPassword($userpass, $enteredpass)
    {
        if (password_verify($enteredpass, $userpass)) return true;
    }

    public function createNewUser($username, $password, $picture)
    {
        $hash = $this->hash($password);
        $sql = "INSERT INTO users (username, `password`, picture) values (?, ?, ?)";
        $statement = $this->db->conn()->prepare($sql);
        $statement->bind_param("sss", $username, $hash, $picture);
        if ($statement->execute()) return true;
        else return false;
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getHotelsJSONByUserId($userId) 
    {
        $sql = "SELECT hotelsJSON FROM users LEFT JOIN hotels ON users.id = hotels.userId WHERE userId = ?";
        $statement = $this->db->conn()->prepare($sql);
        $statement->bind_param("i", $userId);
        if(!$statement->execute()) {
            die("Error couldn't fetch user data.");
        } else {
            $result = $statement->get_result();
            $row = $result->fetch_assoc();
            $bookmarkedHotels = $row['hotelsJSON'];
            return $bookmarkedHotels;
        }
    }

    public function updateBookMarkStateHotel($hotelsJSON, $userId) {
        $sql = "UPDATE hotels SET hotelsJSON = ? WHERE userId = ?";
        $statement = $this->db->conn()->prepare($sql);
        $statement->bind_param("si", $hotelsJSON, $userId);
        if(!$statement->execute()) {
            die("Error couldn't update bookmarkstate");
        } 
    }

    public function createHotelsInstance($userId) {
        $sql = "INSERT INTO hotels (hotelsJSON, userId) VALUES (?, ?)";
        $json = "[]";
        $statement = $this->db->conn()->prepare($sql);
        $statement->bind_param("si", $json, $userId);
        if(!$statement->execute()) {
            die("Error couldn't create new row.");
        } else {
            return true;
        }
    }
}
