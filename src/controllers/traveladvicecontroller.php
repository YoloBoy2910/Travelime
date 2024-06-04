<?php

namespace App\Controllers;

use App\Controller;

class TravelAdviceController extends Controller {

    public function index() {
        $this->render("traveladvice");
    }
}