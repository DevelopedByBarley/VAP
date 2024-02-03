<?php
require_once 'app/controllers/user/User_Controller.php';
require_once 'app/controllers/user/User_Render.php';
require_once 'app/services/AuthService.php';

$r->addRoute('GET', '/user/dashboard', [UserRender::class, 'dashboard']);
$r->addRoute('GET', '/user/settings', [UserRender::class, 'profileSettingsForm']);
$r->addRoute('GET', '/user/password-reset', [UserRender::class, 'resetPasswordForm']);
$r->addRoute('GET', '/user/documents/new', [UserRender::class, 'documentForm']);
$r->addRoute('GET', '/user/documents/update/{id}', [UserRender::class, 'updateUserDocumentForm']);
$r->addRoute('GET', '/user/documents', [UserRender::class, 'userDocuments']);



$r->addRoute('GET', '/activate', [AuthService::class, 'activateRegister']);
$r->addRoute('GET', '/user/logout', [UserController::class, 'logout']);
$r->addRoute('GET', '/user/documents/delete/{id}', [UserController::class, 'deleteUserDocument']);
$r->addRoute('POST', '/user/update', [UserController::class, 'updateUser']);
$r->addRoute('POST', '/user/password-reset', [UserController::class, 'resetPassword']);
$r->addRoute('POST', '/user/delete', [UserController::class, 'deleteUser']);
$r->addRoute('POST', '/user/documents/update/{id}', [UserController::class, 'updateUserDocument']);
$r->addRoute('POST', '/user/documents/new', [UserController::class, 'newDocument']);

