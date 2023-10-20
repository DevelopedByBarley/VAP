<?php
require 'app/controllers/home/Home_Controller.php';
require 'app/controllers/home/Home_Render.php';

$r->addRoute('GET', '/', [HomeRender::class, 'home']);
$r->addRoute('GET', '/success', [HomeRender::class, 'success']);
$r->addRoute('GET', '/error', [HomeRender::class, 'error']);
$r->addRoute('GET', '/language', [HomeController::class, 'setLanguage']);
$r->addRoute('GET', '/language/{lang}', [HomeController::class, 'switchLanguage']);