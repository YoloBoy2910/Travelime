<?php

namespace App\Controllers;

use App\Controller;

class IndexController extends Controller {

    public function index() {
        if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
            header("Location: /Travelime/home");
            exit;
        }
        else {
            $this->render('index');
        }
    }

    public function enterGuestAge() {
        if(isset($_POST['age'])) {
            $age = $_POST['age'];

            if($age >= 18 && $age <= 120) {
                $_SESSION['guest-age'] = $age;
                echo "testing";
                header("Location: /Travelime/login");
                exit;
            } else {
                $_SESSION['message'] = $age . " is invalid. Pls enter an age between 18 and 120.";
                header("Location: /Travelime/");
                exit;
            }
        }
        
    }
}
