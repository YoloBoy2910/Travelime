<?php

namespace App\controllers;

use App\Controller;

class HomeController extends Controller {

    public function index() {
        if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1 ||
        isset($_SESSION['guest-age'])) {
            $this->render('home');
        } else {
            header("Location: /Travelime/");
            exit;
        }
    }
}