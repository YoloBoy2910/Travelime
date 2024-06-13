<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;

class LoginController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
            header("Location: /Travelime/home");
            exit;
        } else $this->render('login');
    }

    public function authenticate()
    {
        $User = new User();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $User->getUserByUsername($username);

        if ($user) {
            $userPassword = $user['password'];
            if ($User->checkPassword($userPassword, $password)) {
                $_SESSION['logged-in'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['message'] = "Welcome back " . $username . "!";
                header("Location: /Travelime/");
                exit;
            } else {
                header("Location: /Travelime/login");
                $_SESSION['message'] = "Password is invalid.";
                exit;
            }
        } else {
            $_SESSION['message'] = "The user: " . $username . " does not exist.";
            header("Location: /Travelime/login");
            exit;
        }
    }

    public function logout()
    {
        if (isset($_POST['logout']) && isset($_SESSION['username'])) unset($_SESSION['username']);
        unset($_SESSION['message']);
        unset($_SESSION['logged-in']);
        header("Location: /Travelime/");
    }
}
