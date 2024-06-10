<?php

namespace App\Controllers;

use App\Controller;
use App\Models\TravelAdvice;

class TravelAdviceController extends Controller
{

    public function index($country = null)
    {
        $TravelAdvice = new TravelAdvice();
        $travelAdvices = $TravelAdvice->getTravelAdvice();

        if ($country) {
            if ($country == "random") $countryAdvice = $TravelAdvice->getRandomCountry();
            else $countryAdvice = $TravelAdvice->getAdviceBycountry($country);

            $this->render("traveladvice", ["travelAdvices" => $travelAdvices, "countryAdvice" => $countryAdvice]);
        } else {
            $this->render("traveladvice", ["travelAdvices" => $travelAdvices]);
        }
    }
}
