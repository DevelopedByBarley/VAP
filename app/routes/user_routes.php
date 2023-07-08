<?php
require 'app/controllers/User_Controller.php';

$r->addRoute('GET', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('GET', '/user/registration', [UserController::class, 'registerForm']);
$r->addRoute('GET', '/language/{lang}', [UserController::class, 'switchLanguage']);



$r->addRoute('POST', '/language', [UserController::class, 'setLanguage']);
$r->addRoute('POST', '/user/register', [UserController::class, 'registerUser']);
