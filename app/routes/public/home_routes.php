<?php
require 'app/controllers/home/Home_Controller.php';
require 'app/controllers/home/Home_Render.php';

$r->addRoute('GET', '/', [HomeRender::class, 'home']);