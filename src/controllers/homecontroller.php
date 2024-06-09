<?php

namespace App\controllers;

use App\Controller;
use App\Models\TravelAdvice;

class HomeController extends Controller {

    public function index() {
        if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1 ||
        isset($_SESSION['guest-age'])) {
            $TravelAdvice = new TravelAdvice();
            $travelAdvices = $TravelAdvice->getTravelAdvice();
            $this->render('home', ["travelAdvices" => $travelAdvices]);
        } else {
            header("Location: /Travelime/");
            exit;
        }
    }
}