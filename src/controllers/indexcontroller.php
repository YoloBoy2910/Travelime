<?php

namespace App\Controllers;

use App\Controller;

class IndexController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
            header("Location: /Travelime/home");
            exit;
        } else {
            $this->render('index');
        }
    }

    public function enterGuestAge()
    {
        if (isset($_POST['age'])) {
            $age = $_POST['age'];

            if ($age >= 16 && $age <= 120) {
                $_SESSION['guest-age'] = $age;

                if ($age < 18) {
                    $_SESSION['age-group'] = 'young';
                } elseif ($age <= 65) {
                    $_SESSION['age-group'] = 'adult';
                } else {
                    $_SESSION['age-group'] = 'elder';
                }

                header("Location: /Travelime/login");
                exit;
            } else {
                $_SESSION['message'] = $age . " is invalid. Pls enter an age between 0 and 120.";
                header("Location: /Travelime/");
                exit;
            }
        }
    }
}
