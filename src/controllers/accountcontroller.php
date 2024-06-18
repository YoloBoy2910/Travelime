<?php

namespace App\controllers;

use App\Controller;

class Accountcontroller extends Controller {

    public function index() {
        $this->render('account');
    }

    public function uploadImage(){
        $this->render('account');
    }
}