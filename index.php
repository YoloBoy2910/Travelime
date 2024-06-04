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

use App\Router;
use App\Database;
use App\Model;

use App\Controllers\IndexController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\TravelAdviceController;

use App\Models\User;

$router = new Router();

//Index routes.
$router->get('/', IndexController::class, 'index');
$router->post('/guestage', IndexController::class, 'enterGuestAge');

//Login related routes.
$router->get('/login', LoginController::class, 'index');
$router->post('/login/authenticate', LoginController::class, 'authenticate');
$router->post('/logout', LoginController::class, 'logout');

//Register related routes.
$router->get('/register', RegisterController::class, 'index');
$router->post('/register/createuser', RegisterController::class, 'register');

//Routes related to home.
$router->get('/home', HomeController::class, 'index');

//Routes related to traveladvice.
$router->get('/traveladvice', TravelAdviceController::class, 'index');

$router->dispatch();