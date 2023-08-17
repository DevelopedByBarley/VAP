<?php
require 'app/controllers/admin/Admin_Controller.php';
require 'app/controllers/admin/Admin_Render.php';
$r->addRoute('GET', '/admin/registrations', [AdminRender::class, 'registrations']);
$r->addRoute('GET', '/admin', [AdminRender::class, 'adminLoginPage']);


$r->addRoute('GET', '/admin/logout', [AdminController::class, 'logoutAdmin']);
$r->addRoute('GET', '/admin/dashboard', [AdminController::class, 'adminDashboard']);



$r->addRoute('POST', '/admin/login', [AdminController::class, 'loginAdmin']);
$r->addRoute('POST', '/admin/register', [AdminController::class, 'registerAdmin']);

