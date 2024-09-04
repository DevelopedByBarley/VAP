<?php
require 'app/controllers/home/Home_Controller.php';
require 'app/controllers/home/Home_Render.php';

$r->addRoute('GET', '/', [HomeRender::class, 'home']);
$r->addRoute('GET', '/maintenance', [HomeRender::class, 'maintenance']);
$r->addRoute('GET', '/cookie-info', [HomeRender::class, 'cookieInfo']);
$r->addRoute('GET', '/partners', [HomeRender::class, 'partners']);
$r->addRoute('GET', '/success', [HomeRender::class, 'success']);
$r->addRoute('GET', '/error', [HomeRender::class, 'errorPage']);
$r->addRoute('POST', '/language', [HomeController::class, 'setLanguage']);
$r->addRoute('GET', '/language/{lang}', [HomeController::class, 'switchLanguage']);
