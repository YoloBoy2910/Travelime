<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;

class LoginController extends Controller {

    public function index() {
        if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
            header("Location: /home"); 
            exit;
        }
        else $this->render('login');
    }

    public function authenticate() {
        $User = new User();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $User->getUserByUsername($username);

        if($user) {
            $userPassword = $user['password'];
            if($User->checkPassword($userPassword, $password)) {
                $_SESSION['logged-in'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['message'] = "Succesfully logged in. Welcome back " . $username . "!";
                header("Location: /");
                exit;
            } else {
                header("Location: /login");
                $_SESSION['message'] = "Password is invalid.";
                exit;
            }
        } else {
            $_SESSION['message'] = "The user: " . $username . " does not exist.";
            header("Location: /login");
            exit;
        }
    }

    public function logout() {
        if(isset($_POST['logout']) && isset($_SESSION['username'])) unset($_SESSION['username']);
        $_SESSION['logged-in'] = 0;
        header("Location: /");
    }
}