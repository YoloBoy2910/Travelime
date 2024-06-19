<?php

namespace App\controllers;

use App\Controller;
use App\Models\User;
use App\Models\TravelAdvice;

class Accountcontroller extends Controller {

    public function index() {
        $User = new User();
        $TravelAdvice =  new TravelAdvice();

        $username = $_SESSION['username'];
        $userData = $User->getUserByUsername($username);
        $travelAdvices = $TravelAdvice->getTravelAdvice();

        $this->render('account', ["user" => $userData, "travelAdvices" => $travelAdvices]);
    }

    public function uploadImage(){
        $this->render('account');
    }
}