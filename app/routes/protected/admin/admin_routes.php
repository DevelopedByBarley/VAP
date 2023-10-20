<?php
require_once 'app/controllers/admin/Admin_Controller.php';
require_once 'app/controllers/admin/Admin_Render.php';
$r->addRoute('GET', '/admin/registrations', [AdminRender::class, 'registrations']);
$r->addRoute('GET', '/admin/user/{id}', [AdminRender::class, 'registeredUser']);


$r->addRoute('GET', '/admin', [AdminRender::class, 'adminLoginPage']);


$r->addRoute('GET', '/admin/logout', [AdminController::class, 'logoutAdmin']);
$r->addRoute('GET', '/admin/dashboard', [AdminController::class, 'adminDashboard']);
$r->addRoute('GET', '/admin/ban-user/{id}', [AdminController::class, 'banUser']);



$r->addRoute('POST', '/admin/login', [AdminController::class, 'loginAdmin']);
$r->addRoute('POST', '/admin/register', [AdminController::class, 'registerAdmin']);
