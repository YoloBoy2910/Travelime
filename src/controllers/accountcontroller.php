<?php

namespace App\controllers;

use App\Controller;
use App\Models\User;
use App\Models\TravelAdvice;

class Accountcontroller extends Controller {

    public function index() {
        $User = new User();
        $username = $_SESSION['username'];
        $userData = $User->getUserByUsername($username);
        $userId = $userData['id'];
        $hotels = json_decode($User->getHotelsJSONByUserId($userId), true);
        $this->render('account', ["user" => $userData, "hotels" => $hotels]);
    }

    public function uploadImage(){
        $this->render('account');
    }

    public function removeBookmark() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $hotelFound = false;
        $keyToRemove = null;

        $hotelId = $data['hotelId'];

        if(isset($_SESSION['username'])) {
            $User = new User();
            $username = $_SESSION['username'];
            $user = $User->getUserByUsername($username);
            $userId = $user['id'];

            $hotelsArray = json_decode($User->getHotelsJSONByUserId($userId), true);

            foreach($hotelsArray as $key => $hotel) {
            if($hotel['hotelId'] == $hotelId) {
                $hotelFound = true;
                $keyToRemove = $key;
                break;
            }
            }
            if($hotelFound) {
                unset($hotelsArray[$keyToRemove]);
                $hotelsArray = array_values($hotelsArray);
            } else {
                return "Error couldn't find hotel in user data";
            }
            
            $hotelsJSON = json_encode($hotelsArray);
            $User->updateBookMarkStateHotel($hotelsJSON, $userId);
            echo json_encode("Succesfully removed bookmark");
        } else {
            //Implement for the guest.
        }
    }
}