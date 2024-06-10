<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;

class RegisterController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) header("Location: /");
        else $this->render('register');
    }

    public function register()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $passcheck = $_POST['passwordcheck'];

        $User = new User();
        $user = $User->getUserByUsername($username);

        if ($user) {
            $_SESSION['message'] = "User " . $username . " already exists.";
            header("Location: /Travelime/register");
            exit;
        } else if ($password == $passcheck) {
            $result = $User->createNewUser($username, $password);
            if ($result) {
                $_SESSION['logged-in'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['message'] = "Succesfully created new user " . $username . "! Welcome to Travellime!";
                header("Location: /Travelime/home");
                exit;
            } else {
                $_SESSION['message'] = "Something went wrong couldn't create new user. Error: " . $result;
                header("Location: /Travelime/register");
                exit;
            }
        } else {
            $_SESSION['message'] = "Passwords don't match.";
            header("Location: /Travelime/register");
            exit;
        }
    }
}
