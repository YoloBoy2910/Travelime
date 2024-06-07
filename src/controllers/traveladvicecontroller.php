<?php

namespace App\Controllers;

use App\Controller;
use App\Models\TravelAdvice;

class TravelAdviceController extends Controller {

    public function index($country = null) {
        $TravelAdvice = new TravelAdvice();
        $travelAdvices = $TravelAdvice->getTravelAdvice();
        if($country) {
            $countryAdvice = $TravelAdvice->getAdviceByCountry($country);
            $this->render("traveladvice", ["travelAdvices" => $travelAdvices, "countryAdvice" => $countryAdvice]);
        } else {
            $this->render("traveladvice", ["travelAdvices" => $travelAdvices]);
        }
    }
}