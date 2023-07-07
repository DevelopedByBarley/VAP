<?php
require 'app/controllers/User_Controller.php';

$r->addRoute('GET', '/language/{lang}', [UserController::class, 'switchLanguage']);
$r->addRoute('POST', '/language', [UserController::class, 'setLanguage']);
