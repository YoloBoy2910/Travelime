<?php

//Start the session.
@session_start();

//Router, model, controller and database base models.
require "src/router.php";
require "src/model.php";
require "src/controller.php";
require "src/database.php";

//Controllers.
require "src/controllers/indexcontroller.php";
require "src/controllers/logincontroller.php";
require "src/controllers/registercontroller.php";
require "src/controllers/homecontroller.php";
require "src/controllers/traveladvicecontroller.php";
require "src/controllers/chatbotcontroller.php";
require "src/controllers/hotelcontroller.php";
require "src/controllers/accountcontroller.php";

//Models.
require "src/models/users.php";
require "src/models/traveladvice.php";
require "src/models/feedback.php";

use App\Router;
use App\Database;
use App\Model;

use App\Controllers\IndexController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\TravelAdviceController;
use App\controllers\ChatbotController;
use App\controllers\HotelController;
use App\controllers\Accountcontroller;

use App\Models\User;
use App\Models\TravelAdvice;
use App\Models\Feedback;

$router = new Router();

//Index routes.
$router->get('/Travelime/', IndexController::class, 'index');
$router->post('/Travelime/guestage', IndexController::class, 'enterGuestAge');
$router->get('/Travelime/getAgeGroup', IndexController::class, 'getAgeGroup');

//Login related routes.
$router->get('/Travelime/login', LoginController::class, 'index');
$router->post('/Travelime/login/authenticate', LoginController::class, 'authenticate');
$router->get('/Travelime/logout', LoginController::class, 'logout');

//Register related routes.
$router->get('/Travelime/register', RegisterController::class, 'index');
$router->post('/Travelime/register/createuser', RegisterController::class, 'register');

//Routes related to home.
$router->get('/Travelime/home', HomeController::class, 'index');
$router->get('/Travelime/home/getFeedbackData', HomeController::class, 'getFeedbackData');

//Routes related to traveladvice.
$router->get('/Travelime/traveladvice', TravelAdviceController::class, 'index');
$router->get('/Travelime/traveladvice/', TravelAdviceController::class, 'index');
$router->get('/Travelime/traveladvice/{country}', TravelAdviceController::class, 'index');

//Chatbot route to communicate with tygo's Chinese friend.
$router->post('/Travelime/sendchatbotmessage', ChatbotController::class, 'sendMessage');

//Routes for searching for hotels.
$router->get('/Travelime/hotels', HotelController::class, 'index');
$router->get('/Travelime/hotels/', HotelController::class, 'index');
$router->get('/Travelime/hotels/{country}', HotelController::class, 'index');
$router->get('/Travelime/getBookmarkedHotels', HotelController::class, 'getBookmarkedHotels');
$router->post('/Travelime/updateBookmarkState', HotelController::class, 'updateBookmarkState');
$router->post('/Travelime/removeBookmark', Accountcontroller::class, 'removeBookmark');

//Routes for account.
$router->get('/Travelime/account', Accountcontroller::class, 'index');
$router->post('/Travelime/account', Accountcontroller::class, 'uploadImage');

$router->dispatch();
