<?php

namespace App\Controllers;

use App\Controller;
use App\Models\TravelAdvice;

class TravelAdviceController extends Controller {

    public function index() {
        $TravelAdvice = new TravelAdvice();
        $travelAdvices = $TravelAdvice->getTravelAdvice();
        $this->render("traveladvice", $travelAdvices);
    }
}