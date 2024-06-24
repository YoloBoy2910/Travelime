<?php

namespace App\controllers;

use App\Controller;
use App\Models\TravelAdvice;
use App\Models\Feedback;

class HomeController extends Controller
{

    public function index()
    {
        if (
            isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1 ||
            isset($_SESSION['guest-age'])
        ) {
            $Feedback = new Feedback();
            $feedback = $Feedback->getFeedbackData();
            $this->render('home', ["feedbacks" => $feedback]);
        } else {
            header("Location: /Travelime/");
            exit;
        }
    }

    //Function for getting the feedback data.
    public function getFeedbackData() {
        $Feedback = new Feedback();
        $feedback = $Feedback->getFeedbackData();
        echo json_encode($feedback);
    }
}
