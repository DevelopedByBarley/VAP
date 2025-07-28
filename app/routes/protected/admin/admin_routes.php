<?php
require_once 'app/controllers/admin/Admin_Controller.php';
require_once 'app/controllers/admin/Admin_Render.php';

$r->addRoute('GET', '/admin', [AdminRender::class, 'adminLoginPage']);
$r->addRoute('GET', '/admin/dashboard', [AdminRender::class, 'adminDashboard']);
$r->addRoute('GET', '/admin/registrations', [AdminRender::class, 'registrations']); 
$r->addRoute('GET', '/admin/user/{id}', [AdminRender::class, 'profile']); 
$r->addRoute('GET', '/admin/user/mail/{id}', [AdminRender::class, 'userMailPage']);
$r->addRoute('GET', '/admin/patch-notes', [AdminRender::class, 'patchNotes']);
$r->addRoute('GET', '/admin/export-all', [UserRender::class, 'exportAll']);



$r->addRoute('GET', '/admin/logout', [AdminController::class, 'logoutAdmin']);
$r->addRoute('GET', '/admin/ban-user/{id}', [AdminController::class, 'banUser']);



$r->addRoute('POST', '/admin/login', [AdminController::class, 'loginAdmin']);
$r->addRoute('POST', '/admin/register', [AdminController::class, 'registerAdmin']);
$r->addRoute('POST', '/admin/user/email/send/{id}', [AdminController::class, 'sendMailToUser']);
