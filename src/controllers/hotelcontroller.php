<?php

namespace App\controllers;

use App\Controller;
use App\Models\TravelAdvice;
use App\Models\User;

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
            $countryAdvice = $TravelAdvice->getAdviceByCountry($country);
            $this->render('hotels', ["travelAdvices" => $travelAdvices, "countryAdvice" => $countryAdvice]);
        } else {
            $TravelAdvice = new TravelAdvice();
            $travelAdvices = $TravelAdvice->getTravelAdvice();
            $this->render('hotels', ["travelAdvices" => $travelAdvices]);
        }
    }

    public function getBookmarkedHotels() {
        if(isset($_SESSION['username'])) {
            //Retrieve the stored hotels for the currently logged in user.
            $User = new User();
            $username = $_SESSION['username'];
            $user = $User->getUserByUsername($username);
            $userId = $user['id'];

            $hotels = $User->getHotelsJSONByUserId($userId);
            echo $hotels;
        } else if(isset($_SESSION['bookmarked-hotels-guest'])) {
            echo json_encode($_SESSION['bookmarked-hotels-guest']);
        }  else {
            $_SESSION['bookmarked-hotels-guest'] = [];
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    public function updateBookmarkState() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $hotelFound = false;

        $incomingHotel = [
            "hotelName" => $data['hotelName'],
            "hotelId" => $data['hotelId'],
            "hotelImage" => $data['hotelImage'],
            "hotelRating" => $data['hotelRating']
        ];

        if(isset($_SESSION['username'])) {
            $User = new User();
            $username = $_SESSION['username'];
            $user = $User->getUserByUsername($username);
            $userId = $user['id'];

            $hotelsArray = json_decode($User->getHotelsJSONByUserId($userId), true);

            if($hotelsArray == []) {
                $hotelsArray[] = $incomingHotel;
            } else {
                foreach($hotelsArray as $key => $hotel) {
                if($hotel['hotelId'] == $incomingHotel['hotelId']) {
                    $hotelFound = true;
                    $keyToRemove = $key;
                    break;
                }
                }
                if($hotelFound) {
                    unset($hotelsArray[$keyToRemove]);
                    $hotelsArray = array_values($hotelsArray);
                } else {
                    $hotelsArray[] = $incomingHotel;
                }
            }

            $hotelsJSON = json_encode($hotelsArray);
            $User->updateBookMarkStateHotel($hotelsJSON, $userId);
        
        } else if(isset($_SESSION['bookmarked-hotels-guest'])) {
            foreach($_SESSION['bookmarked-hotels-guest'] as $key => $hotel) {
                if($hotel['hotelId'] == $hotelId) {
                    $hotelfound = true;
                    $keyToRemove = $key;
                    break;
                }
            }
            if($hotelfound) {
                unset($_SESSION['bookmarked-hotels-guest'][$keyToRemove]);
                echo json_encode("removed");
            } else {
                $_SESSION['bookmarked-hotels-guest'][] = $incomingHotel;
                echo json_encode("bookmarked");
            }
        }
    }
}