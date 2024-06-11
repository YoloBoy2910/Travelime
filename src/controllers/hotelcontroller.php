<?php

namespace App\controllers;

use App\Controller;
use App\Models\TravelAdvice;

class HotelController extends Controller
{

    public function index($country = null)
    {
        if($country) {
             //Check for spaces. Urls turn spaces in %20 cause urls can't have spaces.
            if (str_contains($country, "%20")) {
                $country = str_replace("%20", " ", $country);
            }
            $TravelAdvice = new TravelAdvice();
            $travelAdvices = $TravelAdvice->getTravelAdvice();
            $this->render('hotels', ["travelAdvices" => $travelAdvices, "country" => $country]);
        } else {
            $TravelAdvice = new TravelAdvice();
            $travelAdvices = $TravelAdvice->getTravelAdvice();
            $this->render('hotels', ["travelAdvices" => $travelAdvices]);
        }
    }
}