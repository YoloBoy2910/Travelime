<?php

//Start the session.
session_start();

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

//Models.
require "src/models/users.php";
require "src/models/traveladvice.php";

use App\Router;
use App\Database;
use App\Model;

use App\Controllers\IndexController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\TravelAdviceController;

use App\Models\User;
use App\Models\TravelAdvice;

$router = new Router();

//Index routes.
$router->get('/Travelime/', IndexController::class, 'index');
$router->post('/Travelime/guestage', IndexController::class, 'enterGuestAge');

//Login related routes.
$router->get('/Travelime/login', LoginController::class, 'index');
$router->post('/Travelime/login/authenticate', LoginController::class, 'authenticate');
$router->post('/Travelime/logout', LoginController::class, 'logout');

//Register related routes.
$router->get('/Travelime/register', RegisterController::class, 'index');
$router->post('/Travelime/register/createuser', RegisterController::class, 'register');

//Routes related to home.
$router->get('/Travelime/home', HomeController::class, 'index');

//Routes related to traveladvice.
$router->get('/Travelime/traveladvice', TravelAdviceController::class, 'index');
$router->get('/Travelime/traveladvice/{country}', TravelAdviceController::class, 'index');

$router->dispatch();