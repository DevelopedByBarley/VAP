<?php
require 'app/controllers/Admin_Controller.php';
$r->addRoute('GET', '/administrator', [AdminController::class, 'adminLoginPage']);
$r->addRoute('GET', '/administrator/logout', [AdminController::class, 'logoutAdmin']);
$r->addRoute('GET', '/administrator/dashboard', [AdminController::class, 'adminDashboard']);




$r->addRoute('POST', '/administrator/login', [AdminController::class, 'loginAdmin']);
$r->addRoute('POST', '/administrator/register', [AdminController::class, 'registerAdmin']);
