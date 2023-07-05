<?php
require 'app/controllers/Admin_Controller.php';
$r->addRoute('GET', '/admin', [AdminController::class, 'adminLoginPage']);
$r->addRoute('GET', '/admin/logout', [AdminController::class, 'logoutAdmin']);
$r->addRoute('GET', '/admin/dashboard', [AdminController::class, 'adminDashboard']);




$r->addRoute('POST', '/admin/login', [AdminController::class, 'loginAdmin']);
$r->addRoute('POST', '/admin/register', [AdminController::class, 'registerAdmin']);
