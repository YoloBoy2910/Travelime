<?php

namespace App\Models;

use App\Model;

class User extends Model
{

    public function getUserByUsername($username)
    {
        $sql = "SELECT username, `password` , picture FROM users WHERE username = ?";
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
}
