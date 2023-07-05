<?php
require 'app/controllers/Home_Controller.php';


$r->addRoute('GET', '/', [HomeHandler::class, 'getUsers']);
$r->addRoute('POST', '/', [HomeHandler::class, 'addUser']);
