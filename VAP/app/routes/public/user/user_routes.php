<?php
require_once 'app/controllers/user/User_Controller.php';
require_once 'app/controllers/user/User_Render.php';

$r->addRoute('GET', '/login', [UserRender::class, 'loginForm']);
$r->addRoute('GET', '/user/registration', [UserRender::class, 'registerForm']);
$r->addRoute('GET', '/user/forgot-pw', [UserRender::class, 'forgotPwForm']);
$r->addRoute('GET', '/user/reset-pw', [UserRender::class, 'resetPwForm']);



$r->addRoute('POST', '/user/register', [UserController::class, 'registration']);
$r->addRoute('POST', '/user/login', [UserController::class, 'login']);
$r->addRoute('POST', '/user/pw/new', [UserController::class, 'newPwRequest']);
$r->addRoute('POST', '/user/set-new-pw', [UserController::class, 'setNewPw']);