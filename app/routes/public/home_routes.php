<?php
require 'app/controllers/home/Home_Controller.php';
require 'app/controllers/home/Home_Render.php';

$r->addRoute('GET', '/', [HomeRender::class, 'home']);
$r->addRoute('GET', '/test', [HomeRender::class, 'test']);
$r->addRoute('GET', '/success', [HomeRender::class, 'success']);
$r->addRoute('GET', '/error', [HomeRender::class, 'error']);
