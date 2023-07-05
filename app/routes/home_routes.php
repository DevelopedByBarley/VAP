<?php
require 'app/controllers/Home_Controller.php';


$r->addRoute('GET', '/', [HomeController::class, 'getUsers']);
